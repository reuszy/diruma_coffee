<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\Customer;
use Lcobucci\JWT\Validation\Constraint\ValidAt;
use Midtrans\Snap;

class PaymentController extends Controller
{
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items'             => 'required|array',
            'items.*.id'        => 'required',
            'items.*.name'      => 'required',
            'items.*.price'     => 'required|numeric',
            'items.*.quantity'  => 'required|integer|min:1',
            'address'           => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        // Ngitung harga
        $gross_amount = 0;
        $item_details = [];

        foreach($request->items as $item){
            $gross_amount += ($item['price'] * $item['quantity']);

            // data item untuk midtrans
            $item_details[] = [
                'id'        => $item['id'],
                'price'     => (int)$item['price'],
                'quantity'  => (int)$item['quantity'],
                'name'      => substr($item['name'], 0, 50),
            ];
        }

        // buat data order di database
        $order_no   = 'ORD-' . date('YmdHis') . rand(100, 999);
        $user       = Auth::user();

        // buat order
        $order = Order::create([
            'order_no'              => $order_no,
            'customer_id'           => null,
            'created_by_user_id'    => $user->id,
            'total_price'           => $gross_amount,
            'payment_method'        => 'MIDTRANS',
            'status'                => 'Pending',
            'status_online_pay'     => 'unpaid',
            'order_type'            => 'online',
            'address'               => $request->address,
        ]);

        foreach($request->items as $item){
            $order->orderItems()->create([
                'menu_name' => $item['name'],
                'quantity'  => $item['quantity'],
                'subtotal'  => $item['price'] * $item['quantity'],
            ]);
        }

        //req snap token midtrans
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');

        $params = [
            'transaction_details' => [
                'order_id'      => $order_no,
                'gross_amount'  => (int)$gross_amount,
            ],

            'customer_details'  => [
                'first_name'    => $user->first_name,
                'email'         => $user->email,
                'phone'         => $user->phone_number,
            ],

            'item_details'  => $item_details,
        ];

        try {

            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'status'        => 'success',
                'order_id'      => $order->id,
                'order_no'      => $order_no,
                'snap_token'    => $snapToken,
            ]);

        } catch (\Exception $e) {

            return response()->json(['message' => $e->getMessage()], 500);

        }
    }

}

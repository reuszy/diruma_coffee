<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Midtrans\Snap;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Menu;
use App\Models\SiteSetting;

class PaymentController extends Controller
{

    public function index()
    {
        $cart_items = session()->get('customer', []);

        $gross_amount = 0;
        foreach ($cart_items as $item) {
            $gross_amount += ((float)$item['price'] * (int)$item['quantity']);
        }

        return view('main-site.checkout', [
            'cart'          => $cart_items,
            'subtotal'      => $gross_amount,
            'site_settings' => SiteSetting::first(),
            'order'         => null, 
        ]);
    }

    public function payment(Request $request)
    {
        $cart_items = session()->get('customer', []);

        if (empty($cart_items)) {
            return redirect()->route('menu')->withErrors('Keranjang belanja Anda kosong.');
        }

        foreach($cart_items as $item) {
            $menuCek = Menu::find($item['id']);

            if (!$menuCek) {
                return redirect()->route('catering')->withErrors(
                    "Maaf, katering '{$item['name']} tidak ditemukan atau sudah dihapus."
                );
            }

            if($menuCek->stock < $item['quantity']) {
                return redirect()->route('catering')->withErrors(
                    "Maaf, stok menu '{$item['name']}' tidak mencukupi. Sisa stok saat ini: {$menuCek->stock}"
                );
            }
        }

        $customerDetails = [
            'name'            => $request->input('name') ?? session('customer_details.name'),
            'email'           => $request->input('email') ?? session('customer_details.email'),
            'phone_number'    => $request->input('phone_number') ?? session('customer_details.phone_number'),
            'address'         => $request->input('address') ?? session('customer_details.address'),
            'city'            => $request->input('city') ?? session('customer_details.city'),
            'postcode'        => $request->input('postcode') ?? session('customer_details.postcode'),
            'additional_info' => $request->input('additional_info') ?? session('customer_details.additional_info'),
        ];

        $delivery_fee = 0; 
        $delivery_distance = null;
        $price_per_mile = 0;

        $order_no = 'ORD-' . date('YmdHis');

        $item_details = [];
        $gross_amount = 0;

        foreach ($cart_items as $item) {
            $price = (float)$item['price'];
            $qty = (int)$item['quantity'];
            $subtotal = $price * $qty;

            $item_details[] = [
                'id'       => $item['id'] ?? uniqid(),
                'price'    => (int)round($price),
                'quantity' => $qty,
                'name'     => substr($item['name'], 0, 50), 
            ];

            $gross_amount += $subtotal;
        }

        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');

        \Midtrans\Config::$overrideNotifUrl = 'https://diruma.reuszy.site/api/midtrans-callback';

        try {
            $customer = Customer::create([
                'name'         => $customerDetails['name'] ?? 'Guest',
                'email'        => $customerDetails['email'] ?? 'noemail@example.com',
                'phone_number' => $customerDetails['phone_number'] ?? '0000000000',
                'address'      => implode(', ', array_filter([
                                    $customerDetails['address'] ?? null,
                                    $customerDetails['city'] ?? null,
                                    $customerDetails['postcode'] ?? null
                ])),
            ]);

            $loggedInUserId = Auth::id();

            $order = Order::create([
                'order_no'          => $order_no,
                'customer_id'       => $customer->id,
                'order_type'        => 'online',
                'total_price'       => $gross_amount,
                'status'            => 'pending',
                'status_online_pay' => 'unpaid',
                'payment_method'    => 'MIDTRANS',
                'additional_info'   => $customerDetails['additional_info'] ?? null,
                'created_by_user_id' => $loggedInUserId,
                'delivery_fee'      => 0,
                'delivery_distance' => null, 
                'price_per_mile'    => 0,
            ]);

            foreach ($cart_items as $item) {
                $order->orderItems()->create([
                    'menu_name' => $item['name'],
                    'quantity'  => $item['quantity'],
                    'subtotal'  => (float)$item['price'] * (int)$item['quantity'],
                ]);

                $menuToDeduct = Menu::find($item['id']);
                if($menuToDeduct) {
                    $menuToDeduct->decrement('stock', $item['quantity']);
                }
            }

            $address_payload = [
                'first_name'   => $customer->name,
                'email'        => $customer->email,
                'phone'        => $customer->phone_number,
                'address'      => $customer->address,
                'city'         => $customerDetails['city'] ?? '', 
                'postal_code'  => $customerDetails['postcode'] ?? '',
                'country_code' => 'IDN'
            ];

            $params = [
                'transaction_details' => [
                    'order_id'     => $order_no,
                    'gross_amount' => (int)round($gross_amount),
                ],
                'customer_details' => [
                    'first_name' => $customer->name,
                    'email'      => $customer->email,
                    'phone'      => $customer->phone_number,
                    'billing_address'   => $address_payload,
                    'shipping_address'  => $address_payload
                ],
                'item_details' => $item_details,

                'enabled_payments' => [
                    'other_qris',   // QRIS
                    'echannel',     // Mandiri
                ],
            ];

            $response = Snap::createTransaction($params);
            $snapToken = $response->token;

            return view('customer.proccess-checkout', [
                'snapToken'     => $snapToken,
                'order'         => $order,
                'cart'          => $cart_items,
                'subtotal'      => $gross_amount,
                'site_settings' => SiteSetting::first(),
            ]);

        } catch (\Exception $e) {
            Log::error("Midtrans/DB Error: " . $e->getMessage());
            return redirect()->route('customer.checkout')->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function repay($id)
    {
        $order = Order::where('id', $id)
                        ->where('created_by_user_id', Auth::id())
                        ->with('orderItems')->firstOrFail();

        if($order->status_online_pay !== 'unpaid'){
            return redirect()->route('customer.dashboard')->withErrors('Pesanan sudah dibayar atau dibatalkan');
        }

        $item_details = [];
        foreach ($order->orderItems as $item){
            $item_details[] = [
                'id'        => $item->id,
                'price'     => (int)round($item->subtotal / $item->quantity),
                'quantity'  => (int)$item->quantity,
                'name'      => substr($item->menu_name, 0, 50),
            ];
        }

        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');

        \Midtrans\Config::$overrideNotifUrl = 'https://diruma.reuszy.site/api/midtrans-callback';

        $customerUser = Customer::find($order->customer_id);
        $user = Auth::user(); 

        $new_midtrans_id = $order->order_no . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id'     => $new_midtrans_id,
                'gross_amount' => (int)$order->total_price,
            ],

            'customer_details' => [
                'first_name' => $user->name,
                'email'      => $user->email,
                'phone'      => $user->phone_number,
                'address'    => $customerUser ? $customerUser->address : '',
            ],

            'item_details' => $item_details,
            'enabled_payments' => [
                'other_qris', 'echannel'
            ],
        ];

        try {
            $snapToken = Snap::createTransaction($params);

            return view('customer.proccess-checkout', [
                'snapToken'     => $snapToken->token,
                'order'         => $order,
                'cart'          => [], 
                'subtotal'      => $order->total_price,
                'site_settings' => SiteSetting::first(),
            ]);

        } catch (\Exception $e) {
            return redirect()->route('customer.dashboard')->withErrors('Gagal memproses pembayaran ulang: ' . $e->getMessage());
        }
    }

}
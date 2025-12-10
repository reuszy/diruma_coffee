<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransCallbackController extends Controller
{
    public function callback(Request $request)
    {
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        try {
            $notif = new Notification();

            $transaction = $notif->transaction_status;
            $type = $notif->payment_type;
            $order_id = $notif->order_id;
            $fraud = $notif->fraud_status;

            $order = Order::where('order_no', $order_id)->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $order->update(['status_online_pay' => 'unpaid']);
                    } else {
                        $order->update(['status_online_pay' => 'paid', 'status' => 'completed']);
                    }
                }
            } else if ($transaction == 'settlement') {
                $order->update([
                    'status_online_pay' => 'paid',
                    'status' => 'pending'
                ]);
            } else if ($transaction == 'pending') {
                $order->update(['status_online_pay' => 'unpaid']);
            } else if ($transaction == 'deny') {
                $order->update(['status_online_pay' => 'unpaid', 'status' => 'cancelled']);
            } else if ($transaction == 'expire') {
                $order->update(['status_online_pay' => 'unpaid', 'status' => 'cancelled']);
            } else if ($transaction == 'cancel') {
                $order->update(['status_online_pay' => 'unpaid', 'status' => 'cancelled']);
            }

            return response()->json(['message' => 'Notification processed']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error'], 500);
        }
    }
}

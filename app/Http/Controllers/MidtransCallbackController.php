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

            $grossAmount = $notif->gross_amount;
            $serverKey = config('midtrans.serverKey');
            $signatureKey = $notif->signature_key;
            $statusCode = $notif->status_code;
            $orderId = $notif->order_id;

            $mySignature = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);

            if($signatureKey !== $mySignature) {
                return response()->json([
                    'message' => 'Invalid Signature'
                ], 403);
            }

            $parts = explode('-', $orderId);
            $fixOrderId = $parts[0] . '-' . $parts[1];

            $transaction = $notif->transaction_status;
            $type = $notif->payment_type;
            $fraud = $notif->fraud_status;

            $paymentMethod = 'Midtrans';

            if($type == 'gopay' || $type == 'qris') {

                $paymentMethod = 'QRIS';

            } else if($type == 'echannel') {

                $paymentMethod = 'Mandiri VA';

            }

            $order = Order::where('order_no', $fixOrderId)->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $order->update([
                            'status_online_pay' => 'unpaid',
                            'payment_method'    => $paymentMethod
                        ]);
                    } else {
                        $order->update([
                            'status_online_pay' => 'paid',
                            'status' => 'completed',
                            'payment_method'    => $paymentMethod
                        ]);
                    }
                }
            } else if ($transaction == 'settlement') {
                $order->update([
                    'status_online_pay' => 'paid',
                    'status' => 'pending',
                    'payment_method'    => $paymentMethod
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

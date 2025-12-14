<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $orders = Order::where('created_by_user_id', $userId)
                        ->orderBy('created_at', 'desc')
                        ->with('orderItems')
                        ->get();

        return response()->json([
            'status' => 'success',
            'total' => $orders->count(),
            'data' => $orders
        ]);
    }

    public function show($id)
    {
        $order = Order::with('orderItems')
                      ->where('created_by_user_id', Auth::id())
                      ->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $order
        ]);
    }
}

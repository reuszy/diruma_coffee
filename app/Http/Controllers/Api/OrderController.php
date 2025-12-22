<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    /**
     * @OA\Get(
     * path="/api/orders",
     * tags={"Order Management"},
     * summary="Ambil Semua data order",
     * description="Hanya user dengan role Admin yang bisa mengakses endpoint ini",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="List semua order",
     * @OA\JsonContent()
     * ),
     * @OA\Response(response=403, description="Forbidden (Bukan Admin)")
     * )
     */

    public function index()
    {
        $user = Auth::user();

        if($user->role !== 'global_admin' && $user->role !== 'admin') {
            return response()->json([
                'pesan' => 'Dilarang: Akses Ditolak'
            ]);
        }

        $orders = Order::with('createdByUser', 'orderItems')
                            ->orderBy('created_at', 'desc')
                            ->get();

        return response()->json([
            'status' => 'success',
            'total' => $orders->count(),
            'data' => $orders
        ]);
    }


    /**
     * @OA\Get(
     * path="/api/orders/{id}",
     * tags={"Order Management"},
     * summary="Lihat detail spesifik satu order",
     * description="User hanya bisa lihat miliknya sendiri, Admin bisa lihat punya siapa saja",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail Order ditemukan",
     * @OA\JsonContent()
     * ),
     * @OA\Response(response=404, description="Order tidak ditemukan")
     * )
     */

    public function show($id)
    {
        $user = Auth::user();

        $query = Order::with('orderItems');

        if($user->role !== 'global_admin' && $user->role !== 'admin') {
            return response()->json([
                'pesan' => 'Dilarang: Akses Ditolak'
            ]);
        }

        $order = $query->find($id);

        if (!$order) {
            return response()->json(['message' => 'Tidak ada Order'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $order
        ]);
    }

    
    public function orderUser()
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
}

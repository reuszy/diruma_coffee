<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

    
    /**
     * @OA\Get(
     * path="/api/orders/my-orders",
     * tags={"Order Management"},
     * summary="Ambil data order milik sendiri",
     * description="Menampilkan history order dari user yang sedang login",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="List order user",
     * @OA\JsonContent()
     * )
     * )
     */

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


    /**
     * @OA\Post(
     * path="/api/orders/create",
     * tags={"Order Management"},
     * summary="Buat Order Baru (Checkout)",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"items", "total_price"},
     * @OA\Property(property="total_price", type="number", example=50000),
     * @OA\Property(property="note", type="string", example="Jangan pedas ya"),
     * @OA\Property(
     * property="items",
     * type="array",
     * @OA\Items(
     * type="object",
     * required={"menu_id", "quantity", "price"},
     * @OA\Property(property="menu_id", type="integer", example=1),
     * @OA\Property(property="quantity", type="integer", example=2),
     * @OA\Property(property="price", type="number", example=25000)
     * )
     * )
     * )
     * ),
     * @OA\Response(response=201, description="Order berhasil dibuat"),
     * @OA\Response(response=400, description="Validasi Error")
     * )
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'total_price' => 'required|numeric',
            'items'       => 'required|array|min:1',
            'items.*.menu_id'  => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price'    => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            $order = Order::create([
                'created_by_user_id' => Auth::id(),
                'total_price' => $request->total_price,
                'status' => 'pending',
                'payment_method' => 'MIDTRANS',
                'status_online_pay' => 'unpaid',
                'order_no' => 'ORD-' . date('YmdHis'),
                'note' => $request->note ?? null,
            ]);

            foreach ($request->items as $item) {
                $menuData = Menu::find($item['menu_id']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id'  => $item['menu_id'],
                    'menu_name' => $menuData->name,
                    'quantity' => $item['quantity'],
                    'price'    => $item['price'],
                    'subtotal' => $item['quantity'] * $item['price'],
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Order created successfully',
                'data' => $order->load('orderItems')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to create order: ' . $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Put(
     * path="/api/orders/{id}/status",
     * tags={"Order Management"},
     * summary="Update Status Order",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * @OA\Schema(type="integer")
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"status"},
     * @OA\Property(property="status", type="string", enum={"pending", "processing", "completed", "cancelled"}, example="processing"),
     * @OA\Property(property="payment_status", type="string", enum={"unpaid", "paid"}, example="paid")
     * )
     * ),
     * @OA\Response(response=200, description="Status berhasil diupdate")
     * )
     */

    public function updateStatus(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->role !== 'global_admin' && $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->update([
            'status' => $request->status ?? $order->status,
            'payment_status' => $request->payment_status ?? $order->payment_status,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order status updated',
            'data' => $order
        ]);
    }
}

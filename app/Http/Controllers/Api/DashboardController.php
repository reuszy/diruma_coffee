<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    
    /**
     * @OA\Get(
     * path="/api/admin/dashboard",
     * tags={"Admin Dashboard"},
     * summary="Lihat Statistik Dashboard",
     * description="Menampilkan ringkasan pendapatan, jumlah order, dan statistik lainnya",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Statistik Dashboard",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="success"),
     * @OA\Property(
     * property="data",
     * type="object",
     * @OA\Property(property="total_income", type="number", example=15000000),
     * @OA\Property(property="orders_today", type="integer", example=5),
     * @OA\Property(property="pending_orders", type="integer", example=2),
     * @OA\Property(property="total_customers", type="integer", example=120),
     * @OA\Property(property="recent_orders", type="array", @OA\Items(type="object"))
     * )
     * )
     * ),
     * @OA\Response(response=403, description="Forbidden (Bukan Admin)")
     * )
     */

    public function index()
    {
        $user = Auth::user();

        if($user->role !== 'global_admin' && $user->role !== 'admin') {
            return response()->json([
                'message' => 'Dilarang: Tidak memiliki akses'
            ], 403);
        }

        $totalIncome = Order::where('status_online_pay', 'paid')->sum('total_price');
        $ordersToday = Order::whereDate('created_at', Carbon::today())->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalCusts = User::where('role', 'customer')->count();
        $recentOrders = Order::with('createdByUser')
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();

        return response()->json([
            'status' => 'Sukses',
            'data' => [
                'total_income' => $totalIncome,
                'orders_today' => $ordersToday,
                'pending_orders' => $pendingOrders,
                'total_customers' => $totalCusts,
                'recent_orders' => $recentOrders
            ]
        ]);
    }
}

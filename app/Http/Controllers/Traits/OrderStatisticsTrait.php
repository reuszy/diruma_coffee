<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\DB;

trait OrderStatisticsTrait
{
    public function shareOrderStatistics()
    {
        $totalRevenue = DB::table('orders')
            ->where('status_online_pay', 'paid')
            ->sum('total_price');

        $stats = DB::table('orders')
            ->selectRaw("count(*) as all_orders")
            ->selectRaw("count(case when status = 'pending' then 1 end) as pending")
            ->selectRaw("count(case when order_type = 'online' then 1 end) as online")
            ->selectRaw("count(case when order_type = 'instore' then 1 end) as instore")
            ->first();

        view()->share([
            'totalRevenue'         => $totalRevenue,
            'pending_orders_count' => $stats->pending,
            'online_orders_count'  => $stats->online,
            'instore_orders_count' => $stats->instore,
            'all_orders_count'     => $stats->all_orders,
        ]);
    }
}

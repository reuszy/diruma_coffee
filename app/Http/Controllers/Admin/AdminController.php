<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Controllers\Traits\OrderStatisticsTrait;
use App\Http\Controllers\Traits\AdminViewSharedDataTrait;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    use OrderStatisticsTrait;
    use AdminViewSharedDataTrait;


    public function __construct()
    {
        $this->shareAdminViewData();
        $this->shareOrderStatistics();
        
    }
    
    public function index()
    {
        $currentYear = now()->year;

        $months = collect(range(1, 12))->map(function ($m) {
            return date('F', mktime(0, 0, 0, $m, 1)); // January - December
        });

        $salesRaw = DB::table('orders')
            ->selectRaw('MONTHNAME(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $currentYear)
            ->groupByRaw('MONTH(created_at), MONTHNAME(created_at)')
            ->pluck('count', 'month');

        $revenueRaw = DB::table('orders')
            ->selectRaw('MONTHNAME(created_at) as month, SUM(total_price) as total')
            ->whereYear('created_at', $currentYear)
            ->where('status_online_pay', 'paid')
            ->groupByRaw('MONTH(created_at), MONTHNAME(created_at)')
            ->pluck('total', 'month');

        $formattedSalesData = $months->mapWithKeys(fn($m) => [$m => $salesRaw->get($m, 0)]);
        $formattedRevenueData = $months->mapWithKeys(fn($m) => [$m => $revenueRaw->get($m, 0)]);

        $recentOrders = Order::with('customer') 
            ->latest()
            ->take(5)
            ->get();

        $totalRevenue = DB::table('orders')
            ->where('status_online_pay', 'paid')
            ->sum('total_price');

        $stats = DB::table('orders')
            ->selectRaw("count(*) as all_orders")
            ->selectRaw("count(case when status = 'pending' then 1 end) as pending")
            ->selectRaw("count(case when order_type = 'online' then 1 end) as online")
            ->selectRaw("count(case when order_type = 'instore' then 1 end) as instore")
            ->first();

        return view('admin.dashboard', [
            'formattedSalesData'   => $formattedSalesData,
            'formattedRevenueData' => $formattedRevenueData,
            'totalRevenue'         => $totalRevenue,
            'recentOrders'         => $recentOrders,

            'pending_orders_count' => $stats->pending,
            'online_orders_count'  => $stats->online,
            'instore_orders_count' => $stats->instore,
            'all_orders_count'     => $stats->all_orders,
        ]);
    }
    

    public function viewMyProfile()
    {
        $user = Auth::User();  
        return view('admin.view-my-profile', compact('user'));
    }


    public function editMyProfile()
    {
        $user = Auth::User();  
        return view('admin.edit-my-profile', compact('user'));
    }

    public function updateMyProfile(UpdateProfileRequest $request)
    {
        $user = User::find(Auth::id());
        $validated = $request->validated();
    
        $user->first_name = $validated['first_name'];
        $user->middle_name = $validated['middle_name']; // Optional, so it can be null
        $user->last_name = $validated['last_name'];        
        $user->email = $validated['email'];
        $user->phone_number = $validated['phone_number'];
        $user->address = $validated['address'];
    
        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old profile photo if exists
            if ($user->profile_picture) {
                Storage::delete('profile-picture/' . $user->profile_picture);
            }
    
            // Store new profile photo
            $photoPath = $request->file('profile_photo')->store('profile-picture', 'public');
            $user->profile_picture = basename($photoPath);
        }
    
        // Save the updated user data
        $user->save();
    
        // Return success message
        return back()->with('success', 'Profile updated successfully.');
    }
    

    public function showChangePasswordForm()
    {
        return view('admin.change-password');
    }

    
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:5|confirmed',
        ]);

        $user = User::find(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'Password kamu berhasil diubah.');
    }    
    
}

<?php

namespace App\Http\Controllers\Customer;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateUserRequest;
use App\Http\Controllers\Traits\CartTrait;
use App\Http\Controllers\Traits\OrderNumberGeneratorTrait;
use App\Http\Controllers\Traits\MainSiteViewSharedDataTrait;
use App\Models\Menu;

class CustomerController extends Controller
{


    use CartTrait;
    use MainSiteViewSharedDataTrait;
    use OrderNumberGeneratorTrait;


    public function __construct()
    {
        $this->shareMainSiteViewData();
    }


    public function dashboard()
    {
        $userId = Auth::id();

        $orders = Order::where('created_by_user_id', $userId)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('customer.dashboard', compact('orders'));
    }


    public function show($id)
    {
        $userId = Auth::id();

        $order = Order::where('created_by_user_id', $userId)
                        ->where('id', $id)
                        ->firstOrFail();

        return view('customer.order-details', compact('order'));
    }

    public function create()
    {
        return view('customer.create-account');
    }


    public function store(Request  $request)
    {
        $request->merge(['role' => 'customer']);

        $validated = app(CreateUserRequest::class)->validateResolved();

        $user = User::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'role' =>  $request->role,
            'password' => Hash::make($request->password),
            'notice' => null,
            'status' => 1,
        ]);

        if ($user) {
            $message = ['success' => 'Account created successfully. You can now log in.'];

            return redirect()->route('login')->with($message);
        } else {
            $message = ['error' => 'Failed to create account. Please try again.'];

            return redirect()->back()->withInput()->with($message);
        }

    }


    public function changePassword()
    {
        return view('customer.change-password');
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $request->user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }

}

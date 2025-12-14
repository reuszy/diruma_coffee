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

class CustomerController extends Controller
{


    use CartTrait;
    use MainSiteViewSharedDataTrait;
    use OrderNumberGeneratorTrait;


    public function __construct()
    {
        $this->shareMainSiteViewData();
    }
    
    // Show the customer dashboard
    public function dashboard()
    {
        $userId = Auth::id();

        $orders = Order::where('created_by_user_id', $userId)
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('customer.dashboard', compact('orders'));
    }

    // Show the account creation form
    public function create()
    {
        return view('customer.create-account');
    }

    // Store a new customer
    public function store(Request  $request)
    {
        // user role as customer
        $request->merge(['role' => 'customer']);

        // Validate using CreateUserRequest rules
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
            // auth::login($user);
            return redirect()->route('login')->with($message);
        } else {
            $message = ['error' => 'Failed to create account. Please try again.'];
            return redirect()->back()->withInput()->with($message);
        }

    }

}

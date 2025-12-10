<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Customer;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Traits\OrderStatisticsTrait;
use App\Http\Controllers\Traits\AdminViewSharedDataTrait;
use App\Http\Controllers\Traits\OrderNumberGeneratorTrait;

class OrderController extends Controller
{
    use AdminViewSharedDataTrait;
    use OrderStatisticsTrait;
    use OrderNumberGeneratorTrait;

    public function __construct()
    {
        $this->shareAdminViewData();
        $this->shareOrderStatistics();
        
    }


    public function index(Request $request, $filter = null)
    {
        // Define allowed filters
        $allowedFilters = ['pending', 'online', 'instore'];

        if ($filter && !in_array($filter, $allowedFilters)) {
            return redirect()->route('admin.orders.index')->with('error', 'Invalid filter value.');
        }

        if ($request->ajax()) {
 
            $orders = Order::select(['id', 'order_no', 'created_at', 'total_price', 'status','status_online_pay', 'order_type'])->orderBy('id', 'desc');

            // Apply filters
            if ($filter) {
                if ($filter == 'pending') {
                    $orders = $orders->where('status', 'pending');
                } elseif ($filter == 'online') {
                    $orders = $orders->where('order_type', 'online');
                } elseif ($filter == 'instore') {
                    $orders = $orders->where('order_type', 'instore');
                }
            }

            return Datatables::of($orders)
                    ->addIndexColumn()
                    ->addColumn('action', function ($order) {
                        $viewButton = '<a href="'.route('admin.order.show', $order->id).'" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i></a>';
                        $deleteButton = Auth::user()->role == "global_admin"  ? '<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="'.$order->id.'"><i class="fa fa-trash"></i></button>'   : '';
                        return $viewButton . ' ' . $deleteButton;
                    })
                    ->editColumn('order_no', function ($order) {
                        return "#".$order->order_no;
                    })                  
                    ->editColumn('created_at', function ($order) {
                        return $order->created_at->format('g:i A -  j M, Y');
                    })          
                    ->editColumn('total_price', function ($order) {
                        $site_settings      =   SiteSetting::latest()->first();
                        $currency_symbol    =   $site_settings->currency_symbol ?? config('site.currency_symbol');
                        return html_entity_decode($currency_symbol) . number_format($order->total_price, 2);
                    })
                    // --- BAGIAN EDIT STATUS DATABASE (MODIFIKASI UTAMA) ---
                    ->editColumn('status', function ($order) {
                        
                        $statuses = [
                            'pending'   => 'Pending', 
                            'delivered' => 'Delivered', 
                            'completed' => 'Completed'
                        ];

                        if (Auth::user()->role == 'global_admin') {
                            $options = '';
                            foreach ($statuses as $value => $label) {
                                $selected = $order->status == $value ? 'selected' : '';
                                $options .= "<option value='$value' $selected>$label</option>";
                            }
                            
                            $url = route('admin.orders.update', $order->id);
                            $csrf = csrf_field();

                            return "
                                <form action='$url' method='POST' style='display:inline-block'>
                                    $csrf
                                    <select name='status' class='form-control form-control-sm text-white' 
                                            style='width:auto; height:30px; padding:0 10px; background-color: #4B49AC; border:none;' 
                                            onchange='this.form.submit()'>
                                        $options
                                    </select>
                                </form>
                            ";
                        } 
                        
                        // JIKA BUKAN ADMIN: TAMPILKAN BADGE BIASA
                        else {
                            $badgeClass = 'badge-secondary';
                            if ($order->status == 'pending') $badgeClass = 'badge-warning';
                            if ($order->status == 'delivered') $badgeClass = 'badge-info';
                            if ($order->status == 'completed') $badgeClass = 'badge-success';

                            return '<span class="badge '.$badgeClass.'">' . ucfirst($order->status) . '</span>';
                        }
                    })
                    // ------------------------------------------------------

                    ->editColumn('order_type', function ($order) {
                        return ucfirst($order->order_type);
                    })                  
                    ->rawColumns(['action','status', 'status_online_pay']) // Jangan lupa tambahkan status_online_pay disini jika Anda merender HTML badge di JS view
                    ->make(true);
        }
          
        return view('admin.orders-index', compact('filter'));
    }
    
    public function show($id)
    {
        $order = Order::with(['orderItems', 'createdByUser', 'updatedByUser', 'customer'])->findOrFail($id);
        
        return view('admin.orders-show', compact('order'));
    }
    


    public function createOrder(Request $request)
    {
        $cart = session()->get($request->cartkey, []);
        if (empty($cart)) {
            return back()->with('error', 'Cart is empty!');

        }

        $totalPrice = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        // Validate request data
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
            'payment_method' => 'required|max:255',  
            'additional_info' => 'nullable|string|max:255',           
        ]);

        // Check if at least one of the fields is provided then Create a new customer
        if ($request->filled(['name', 'email', 'phone_number', 'address'])) {
            // Create the customer
            $customer = Customer::create([
                'name' => $validatedData['name'] ?? null,
                'email' => $validatedData['email'] ?? null,
                'phone_number' => $validatedData['phone_number'] ?? null,
                'address' => $validatedData['address'] ?? null,
            ]);

            $customer_id = $customer->id;

        } else {
            $customer_id = null;
        }

        // Generate a unique 7-digit order number
        $order_no = $this->generateOrderNumber();

        // Create a new order
        $order = Order::create([
            'customer_id' => $customer_id,
            'order_no' => $order_no,
            'order_type' => 'instore',
            'created_by_user_id' => Auth::id(),
            'updated_by_user_id' => Auth::id(),
            'total_price' => $totalPrice,
            'status' => 'completed',
            'payment_method' => $validatedData['payment_method'],
            'additional_info' => $validatedData['additional_info'],
            'delivery_fee' => null,
            'delivery_distance' => null,
            'price_per_mile' => null,

        ]);

        if ($order) {
            // Create order items using the relationship
            foreach ($cart as $item) {
                $order->orderItems()->create([
                    'menu_name' => $item['name'],  
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
            }
        }

        // Clear the cart
        session()->forget($request->cartkey);

        return redirect()->route('admin.orders.index')->with('success', 'Order Created successfully.');
    }

    
    public function update(Request $request, $id)
    {
        // Validasi input sesuai enum database
        $request->validate([
            'status' => 'required|in:pending,completed,delivered',
        ]);
        
        $order = Order::findOrFail($id);

        // Update status
        $order->update([
            'status' => $request->status, 
            'updated_by_user_id' => Auth::id()
        ]);
    
        return back()->with('success', 'Order status updated successfully');
    }

 
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->deleteWithRelations();

        return redirect()->route('admin.orders.index')->with('success', 'Order have been deleted successfully.');
    }
}

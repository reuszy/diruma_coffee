<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\Traits\AdminViewSharedDataTrait;

class UserAdminController extends Controller
{

    use AdminViewSharedDataTrait;

    public function __construct()
    {
        $this->shareAdminViewData();
        
    }
    
    // Show the admin management page
    public function index()
    {
        // Get all users except the logged-in user
        $users = User::where('id', '!=', Auth::id())->get();
        return view('admin.manage-users', compact('users'));
    }

    // Store a new admin
    public function store(CreateUserRequest $request)
    {
        User::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => 1,
            'password' => Hash::make('password'),
            'notice' => 'change_password_to_activate_account',
        ]);
    
        return redirect()->route('admin.users.index');
    }
    

    // Update akun
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);
    
        if($user->notice !="change_password_to_activate_account"){

        // Determine ban status and set fields accordingly
        $isBanned = $request->has('ban') && $request->ban === 'on';
        $status = $isBanned ? 0 : 1;
        $notice = $isBanned ? "banned" : null;
        }
        else
        {
            $status = $user->status;
            $notice = $user->notice;
        }
        
        // Update the user
        $user->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $status,
            'notice' => $notice,
        ]);
    
        return back()->with('success', 'User updated successfully.');
    }
    

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);

        $user->password = Hash::make('password');
        $user->save();

        return redirect()->back()->with('success', 'Password user ' . $user->first_name . ' berhasil direset menjadi "password".');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}

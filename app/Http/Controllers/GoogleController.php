<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }


    public function callback()
    {
        try {

            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->email)->first();

            if(!$user) {

                $user = User::create([
                    'first_name' => $googleUser->user['given_name'] ?? $googleUser->name,
                    'last_name'  => $googleUser->user['family_name'] ?? '',
                    'email'     => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password'  => Hash::make(Str::random(16)),
                    'role'      => 'customer',
                    'status'    => 1,
                ]);

            } else {

                $user->update([
                    'google_id' => $googleUser->id,
                ]);

            }

            Auth::login($user);

            return redirect()->route('home');

        } catch (\Exception $e) {

            return redirect()->route('login')->with('error', 'Gagal login Google: ' . $e->getMessage());

        }
    }

}

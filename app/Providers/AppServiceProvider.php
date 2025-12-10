<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\SocialMediaHandle;
use App\Models\RestaurantAddress;
use App\Models\RestaurantPhoneNumber;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {

        //URL::forceScheme('https');

        View::composer('*', function ($view) {

            $customer_total_cart_items = 0;
            if (Auth::check() && Auth::user()->role === 'customer') {
                $cart = session('cart', []);
                $customer_total_cart_items = array_sum(array_column($cart, 'quantity'));
            }

            $socialMediaHandles = SocialMediaHandle::all(); 
            
            $whatsAppNumber = RestaurantPhoneNumber::first();; 
            $firstRestaurantAddress = RestaurantAddress::first();;
            $firstRestaurantPhoneNumber = null;

            $view->with([
                'customer_total_cart_items'   => $customer_total_cart_items,
                'socialMediaHandles'          => $socialMediaHandles,
                'whatsAppNumber'              => $whatsAppNumber,
                'firstRestaurantAddress'      => $firstRestaurantAddress,
                'firstRestaurantPhoneNumber'  => $firstRestaurantPhoneNumber,
            ]);
        });
    }
}
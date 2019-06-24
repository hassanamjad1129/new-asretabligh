<?php

namespace App\Providers;

use App\BestCustomer;
use App\option;
use App\pricelist;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
        view()->composer('client.layout.master', function ($view) {
            $address = option::where('option_name', 'address')->first()->option_value;
            $bestCustomers = BestCustomer::all();
            $phone = option::where('option_name', 'phone')->first()->option_value;
            $email = option::where('option_name', 'email')->first()->option_value;
            $prices = pricelist::orderBy('priority')->get();
            $cart = count(Session::get('cart'));
            $view->with(['cart' => $cart, 'address' => $address, 'phone' => $phone, 'email' => $email, 'bestCustomers' => $bestCustomers, 'prices' => $prices]);
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

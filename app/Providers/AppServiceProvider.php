<?php

namespace App\Providers;

use App\BestCustomer;
use App\Models\Category;
use App\option;
use App\OrderItem;
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
            $categories = Category::all();
            $cart = Session::get('cart') ? count(Session::get('cart')) : 0;
            $view->with(['cart' => $cart, 'address' => $address, 'phone' => $phone, 'email' => $email, 'bestCustomers' => $bestCustomers, 'categories' => $categories]);
        });
        view()->composer('admin.layout.sidebar', function ($view) {
            $notStartedOrders = OrderItem::where('status', 1)->get()->count();
            $view->with(['notStartedOrders' => $notStartedOrders]);
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

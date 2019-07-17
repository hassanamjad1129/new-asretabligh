<?php

use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('customer')->user();

    //dd($users);

    return view('customer.home');
})->name('home');
Route::post('/home', 'HomeController@updateProfile');
Route::get('/login', 'CustomerAuth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'CustomerAuth\LoginController@login');
Route::get('/logout', 'CustomerAuth\LoginController@logout')->name('logout');

Route::get('/register', 'CustomerAuth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'CustomerAuth\RegisterController@register');

Route::post('/password/email', 'CustomerAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
Route::post('/password/reset', 'CustomerAuth\ResetPasswordController@reset')->name('password.email');
Route::get('/password/reset', 'CustomerAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
Route::get('/password/reset/{token}', 'CustomerAuth\ResetPasswordController@showResetForm');


Route::group(['middleware' => 'customer', 'namespace' => 'Customer'], function () {
    Route::get('/home', 'HomeController@dashboard')->name('customerHome')->middleware('customer');
    Route::post('/finalStep', 'OrderController@finalStep')->name('finalStep');
    Route::post('storeOrder', 'OrderController@storeOrder')->name('storeOrder');
    Route::get('/order/verifyOrder', 'OrderController@verifyOrder');
    Route::post('/order/verifyOrder', 'OrderController@verifyOrder');
    Route::get('orders', 'OrderController@index')->name('orders');
    Route::get('orders/{orderItem}', 'OrderController@orderDetail')->name('orderDetail');
});
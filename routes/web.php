<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'siteController@index');
Route::get('getProductPicture/{product}', 'siteController@getProductPicture');
Route::get('getCategoryPicture/{category}', 'siteController@getCategoryPicture');
Route::get('getValuePicture/{value}', 'siteController@getValuePicture')->name('getValuePicture');
Route::get('getServicePicture/{service}', 'siteController@getServicePicture')->name('getServicePicture');
Route::get('category/{category}', 'siteController@getCategoryProductPrice')->name('categoryProductPrice');
Route::get('قوانین-مقررات', 'siteController@rules')->name('rules');
Route::get('درباره-ما', 'siteController@aboutus')->name('aboutus');

Route::get('product/{product}', 'ProductController@show')->name('showProduct');
Route::post('checkFiles', 'Customer\OrderController@checkFiles')->name('checkFiles');
Route::post('fetchServiceProperties', 'Customer\OrderController@fetchServiceProperties')->name('fetchServiceProperties');
Route::post('fetchPaperServices', 'Customer\OrderController@fetchPaperServices')->name('fetchPaperServices');
Route::post('fetchOrderPrice', 'Customer\OrderController@fetchOrderPrice')->name('fetchOrderPrice');
Route::post('fetchServicePrice', 'Customer\OrderController@fetchServicePrice')->name('fetchServicePrice');
Route::post('storeOrder', 'Customer\OrderController@storeCart')->name('storeCart');
Route::get('/cart', 'siteController@cart')->name('cart');
Route::get('/cart/{id}/remove', 'siteController@removeFromCart');

Route::get('/posts/{post}/{title}', 'siteController@postDetail')->name('post.detail');

Route::group(['middleware' => 'web'], function () {
    Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
    Route::post('/laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');
    // list all lfm routes here...
});

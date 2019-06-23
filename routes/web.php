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

Route::get('product/{product}', 'ProductController@show')->name('showProduct');

Route::group(['middleware' => 'web'], function () {
    Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
    Route::post('/laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');
    // list all lfm routes here...
});

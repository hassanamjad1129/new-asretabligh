<?php
Route::group(['middleware' => 'admin'], function () {
    Route::get('/home', function () {
        $users[] = Auth::user();
        $users[] = Auth::guard()->user();
        $users[] = Auth::guard('admin')->user();

        //dd($users);

        return view('admin.home');
    })->name('home');

    //All Routes We Have in Admin Sidebar Panel :|
    Route::group(['namespace' => 'Admin', 'middleware' => 'admin'], function () {
        Route::resource('posts', 'PostController');
        Route::resource('categories', 'CategoryController');
        Route::resource('pCategories', 'PostCategoryController');
        Route::resource('bestCustomers', 'BestCustomersController');
        Route::resource('shipping', 'ShippingController');
        //Get Picture of Category
        Route::get('/categories/getPicture/{category}', 'CategoryController@categoryPicture')->name('categoryPicture');
        //Get Picture of Subcategories
        Route::get('/Subcategories/getPicture/{subcategory}', 'SubcategoryController@subcategoryPicture')->name('subcategoryPicture');
        Route::resource('/categories/{category}/subcategories', 'SubcategoryController');
        Route::get('/Products/getPicture/{product}', 'ProductController@productPicture')->name('productPicture');
        Route::resource('/{category}/products', 'ProductController');
        Route::resource('/product/{product}/productProperties', 'ProductPropertyController');
        Route::get('/productAnswers/getPicture/{productAnswer}', 'ProductPropertyController@ProductAnswer')->name('ProductAnswer');
        Route::get('product/{product}/productProperties/{productProperty}/productAnswer/{productValue}', 'ProductPropertyController@destroyValue')->name('destroyValue');
        Route::resource('/{category}/products/{product}/productPrice', 'ProductPriceController');
        Route::resource('/{category}/products/{product}/productFile', 'productFileController');

        Route::post('/ajaxProductProperties', 'ProductPriceController@ajaxProductProperties');
        Route::post('/ajaxProductAnswers', 'ProductPriceController@ajaxProductAnswers');
        Route::post('/ajaxProductPrices', 'ProductPriceController@ajaxProductPrices');
        Route::post('/ajaxRemoveProductPrice', 'ProductPriceController@ajaxRemoveProductPrice');
        Route::post('/ajaxSubmitForm', 'ProductPriceController@ajaxSubmitForm');

        Route::post('/ajaxProducts', 'ProductPropertyController@ajaxProducts');
        Route::resource('/user', 'UserController');
        Route::resource('/admins', 'AdminController');
        Route::resource('slideshow', 'SlideshowController');
        Route::get('/slideshow/delete/{id}', 'SlideshowController@destroy');
        Route::post('/slideshow/setPriority', 'SlideshowController@setPriority')->middleware('admin');

    });
});
Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('login')->middleware('web');
Route::post('/login', 'AdminAuth\LoginController@login')->middleware('web');
Route::post('/logout', 'AdminAuth\LoginController@logout')->name('logout');

Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'AdminAuth\RegisterController@register');

Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.email');
Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
<?php
Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('/home', function () {
        $users[] = Auth::user();
        $users[] = Auth::guard()->user();
        $users[] = Auth::guard('admin')->user();

        //dd($users);

        return view('admin.home');
    })->name('home');

    //All Routes We Have in Admin Sidebar Panel :|
    Route::group(['namespace' => 'Admin', 'middleware' => 'auth:admin'], function () {
        Route::resource('posts', 'PostController');
        Route::resource('categories', 'CategoryController');
        Route::resource('pCategories', 'PostCategoryController');
        Route::resource('bestCustomers', 'BestCustomersController');
        Route::resource('shipping', 'ShippingController');
        Route::resource('service', 'ServiceController');
        //Get Picture of Category
        Route::get('/categories/getPicture/{category}', 'CategoryController@categoryPicture')->name('categoryPicture');
        //Get Picture of Subcategories
        Route::get('/Subcategories/getPicture/{subcategory}', 'SubcategoryController@subcategoryPicture')->name('subcategoryPicture');
        Route::resource('/categories/{category}/subcategories', 'SubcategoryController');
        Route::get('/Products/getPicture/{product}', 'ProductController@productPicture')->name('productPicture');
        Route::resource('/{category}/products', 'ProductController');
        Route::get('/{category}/products/{product}/papers', 'ProductController@papers')->name('products.papers');
        Route::post('/{category}/products/{product}/papers', 'ProductController@updatePapers');

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
        Route::resource('/customer', 'UserController');
        Route::get('/customer/{customer}/orders', 'UserController@orders')->name('customer.orders');

        Route::resource('/admins', 'AdminController');
        Route::get('admins/{admin}/roles', 'adminController@roles')->name('admins.roles');
        Route::post('admins/{admin}/roles', 'adminController@updateRoles')->name('admins.updateRoles');

        Route::resource('slideshow', 'SlideshowController');
        Route::resource('roles', 'roleController');
        Route::get('rolePermissions/{role}', 'roleController@permissions')->name('rolePermissions');
        Route::post('rolePermissions/{role}', 'roleController@updatePermissions');

        Route::resource('permissions', 'permissionController');

        Route::get('/slideshow/delete/{id}', 'SlideshowController@destroy');
        Route::post('/slideshow/setPriority', 'SlideshowController@setPriority')->middleware('admin');

        Route::get('/customer/{customer}/moneybag', 'MoneyBagController@index')->name('moneybag.index');
        Route::get('/customer/{customer}/moneybag/create', 'MoneyBagController@create')->name('moneybag.create');
        Route::post('/customer/{customer}/moneybag', 'MoneyBagController@store');
        Route::delete('/customer/{customer}/moneybag/{report}', 'MoneyBagController@destroy')->name('moneybag.delete');

        Route::get('service/{service}/products', 'ServiceController@products')->name('service.products');
        Route::post('service/{service}/products', 'ServiceController@updateProducts');

        Route::resource('/services/{service}/serviceProperties', 'ServicePropertyController');
        Route::get('/serviceAnswers/getPicture/{serviceAnswer}', 'ServicePropertyController@ServiceAnswer')->name('ServiceAnswer');
        Route::get('services/{service}/serviceProperties/{serviceProperty}/serviceAnswer/{serviceValue}', 'ServicePropertyController@destroyValue')->name('destroyServiceValue');
        Route::resource('services/{service}/servicePrice', 'ServicePriceController');

        Route::post('/ajaxServiceProperties', 'ServicePriceController@ajaxServiceProperties');
        Route::post('/ajaxServiceAnswers', 'ServicePriceController@ServiceAnswers');
        Route::post('/ajaxServicePrices', 'ServicePriceController@ajaxServicePrices');
        Route::post('/ajaxRemoveServicePrice', 'ServicePriceController@ajaxRemoveServicePrice');
        Route::post('/ajaxServiceSubmitForm', 'ServicePriceController@ajaxSubmitForm');

        Route::resource('paper', 'PaperController');
        Route::get('paper/{paper}/products', 'PaperController@products')->name('paper.products');
        Route::post('paper/{paper}/products', 'PaperController@updateProducts');

        Route::get('orders', 'OrderController@index')->name('orders.index');
        Route::get('orders/finished', 'OrderController@finished')->name('orders.finished');
        Route::get('orders/{orderItem}', 'OrderController@orderDetail')->name('orders.orderDetail');
        Route::post('orders/{orderItem}', 'OrderController@updateOrder')->name('orders.updateOrder');

        Route::get('options', 'OptionController@getOptions')->name('getOptions');
        Route::post('options', 'OptionController@updateOptions');
    });
});
Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('login')->middleware('web');
Route::post('/login', 'AdminAuth\LoginController@login')->middleware('web');
Route::post('/logout', 'AdminAuth\LoginController@logout')->name('logout');

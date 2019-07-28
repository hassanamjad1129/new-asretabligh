<?php
Route::group(['middleware' => 'auth:admin'], function () {
    Route::group(['namespace' => 'Admin', 'middleware' => 'auth:admin'], function () {
        Route::get('/home', 'HomeController@dashboard')->name('home');
        Route::post('/home', 'HomeController@updateDashboard');

        //All Routes We Have in Admin Sidebar Panel :|

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
        Route::post('/customer/{customer}/orders', 'UserController@filterOrders');

        Route::resource('/admins', 'AdminController');
        Route::get('admins/{admin}/roles', 'AdminController@roles')->name('admins.roles');
        Route::post('admins/{admin}/roles', 'AdminController@updateRoles')->name('admins.updateRoles');

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

        Route::get('orders/report', 'OrderController@report')->name('orders.report');
        Route::post('orders/report', 'OrderController@filterReport');

        Route::get('orders/{orderItem}', 'OrderController@orderDetail')->name('orders.orderDetail');
        Route::post('orders/{orderItem}', 'OrderController@updateOrder')->name('orders.updateOrder');

        //start discount
        Route::get('discount', 'DiscountController@index')->name('discount.index');
        Route::get('discount/{discount}/status', 'DiscountController@changeStatus')->name('discount.changeStatus')->where('discount', '[0-9]+');
        Route::delete('discount/{discount}/delete', 'DiscountController@delete')->name('discount.delete')->where('discount', '[0-9]+');
        Route::get('discount/create', 'DiscountController@create')->name('discount.create');
        Route::post('discount/store', 'DiscountController@store')->name('discount.store');
        Route::post('discount/generate/code', 'DiscountController@generateCode')->name('discount.generate.code');
        Route::get('discount/{discount}/edit', 'DiscountController@edit')->name('discount.edit');
        Route::patch('discount/{discount}/update', 'DiscountController@update')->name('discount.update');
        //end discount

        Route::get('options', 'OptionController@getOptions')->name('getOptions');
        Route::post('options', 'OptionController@updateOptions');
    });
});
Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('login')->middleware('web');
Route::post('/login', 'AdminAuth\LoginController@login')->middleware('web');
Route::post('/logout', 'AdminAuth\LoginController@logout')->name('logout');

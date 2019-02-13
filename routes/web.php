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

Auth::routes();

Route::get('/', 'HomeController@home')->name('home');
Route::get('/shop', 'HomeController@shop')->name('shop');
Route::get('/contact', 'HomeController@contact')->name('contact');

Route::get('/oauth/{provider}/redirect', 'Auth\LoginController@redirectToProvider');
Route::get('/oauth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/product/{product}', 'Shop\ProductController@index')->name('productPage');
Route::get('/product/{product}/{choice}/buy', 'Shop\ProductController@buyNow');

Route::get('/cart', 'Cart\CartController@index');
Route::get('/cart/get', 'Cart\CartController@get');
Route::get('/cart/clear', 'Cart\CartController@clear');
Route::put('/cart/add/{product}', 'Cart\CartController@addToCart');
Route::put('/cart/update/qty', 'Cart\CartController@updateQty');
Route::put('/cart/update/remove', 'Cart\CartController@removeFromCart');

Route::get('/profile', 'User\UserController@index');
Route::get('/profile/edit', 'User\UserController@edit');
Route::put('/profile/edit', 'User\UserController@update');
/*
|--------------------------------------------------------------------------
| Auth Middleware Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth']], function () {
  Route::get('/order', 'Order\OrderController@index');
  Route::get('/order/{order}', 'Order\OrderController@orderView');
  Route::get('/order/{order}/payment', 'Order\OrderController@paymentView')->name('payment');

  Route::get('/order/{order}/payment/notify', 'Admin\Payment\PaymentController@transaction');
  Route::put('/order/{order}/payment/confirm_trans', 'Admin\Payment\PaymentController@confirmTransaction')->name('confirmTransaction');

  Route::post('/cart/confirm', 'Order\OrderController@create');
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin', 'Admin\AdminController@index')->name('adminIndex');
Route::get('/admin/contact', 'Admin\AdminController@index');
Route::get('/admin/shipping', 'Admin\AdminController@index');
Route::get('/admin/orders', 'Admin\AdminController@index');
Route::get('/admin/orders/{order}', 'Admin\AdminController@index');
Route::get('/admin/banner', 'Admin\AdminController@index');
Route::get('/admin/payment', 'Admin\AdminController@index');
Route::get('/admin/showcase', 'Admin\AdminController@index');
Route::get('/admin/showcase/{showcase}/edit', 'Admin\AdminController@index');
/*
|--------------------------------------------------------------------------
| Product
|--------------------------------------------------------------------------
*/
Route::get('/admin/product', 'Admin\Product\ProductController@index')->name('adminProduct');
Route::get('/admin/product/upload', 'Admin\Product\ProductController@index');
Route::post('/admin/product/create', 'Admin\Product\ProductController@create');
Route::delete('/admin/product/delete/{product}', 'Admin\Product\ProductController@delete');
Route::put('/admin/product/feature/{product}', 'Admin\Product\ProductController@addToHome');
/*
|--------------------------------------------------------------------------
| Stock
|--------------------------------------------------------------------------
*/
Route::get('/admin/product/stock', 'Admin\Product\ProductController@index');
Route::put('/admin/product/stock/{product}', 'Admin\Product\StockController@update');
/*
|--------------------------------------------------------------------------
| Photo
|--------------------------------------------------------------------------
*/
Route::get('/admin/product/{product}/edit', 'Admin\Product\ProductController@index');
Route::put('/admin/product/{product}/update', 'Admin\Product\EditController@update');
Route::get('/admin/product/{product}/get_photo', 'Admin\Product\PhotoController@get');
Route::post('/admin/product/{product}/upload_photo', 'Admin\Product\PhotoController@upload');
Route::delete('/admin/product/delete_photo/{id}', 'Admin\Product\PhotoController@delete');
/*
|--------------------------------------------------------------------------
| Product Choice
|--------------------------------------------------------------------------
*/
Route::get('/admin/product/{product}/get_choice', 'Admin\Product\ChoiceController@get');
Route::put('/admin/product/{product}/add_choice', 'Admin\Product\ChoiceController@create');
Route::put('/admin/product/{product}/delete_choice', 'Admin\Product\ChoiceController@delete');
/*
|------------------------------------------------------------------------payment--
| Prommotions
|--------------------------------------------------------------------------
*/
Route::get('/admin/promotions/discount', 'Admin\Product\ProductController@index');
Route::put('/admin/promotions/discount/{product}/apply', 'Admin\Promotion\DiscountController@applyDiscount');
Route::put('/admin/promotions/discount/{product}/cancle', 'Admin\Promotion\DiscountController@cancleDiscount');

Route::get('/admin/promotions/code', 'Admin\Product\ProductController@index');
Route::post('/admin/promotions/code/create', 'Admin\Promotion\CodeController@create');
Route::delete('/admin/promotions/code/delete/{id}', 'Admin\Promotion\CodeController@delete');
/*
|--------------------------------------------------------------------------
| Category
|--------------------------------------------------------------------------
*/
Route::get('/admin/category', 'Admin\Product\ProductController@index');
Route::post('/admin/category/add', 'Admin\Category\CategoryController@create');
Route::put('/admin/category/update', 'Admin\Category\CategoryController@update');
Route::delete('/admin/category/delete/{category}', 'Admin\Category\CategoryController@delete');
/*
|--------------------------------------------------------------------------
| Contact
|--------------------------------------------------------------------------
*/

Route::post('/admin/contact/add', 'Admin\Contact\ContactController@create');
Route::put('/admin/contact/update/{contact}', 'Admin\Contact\ContactController@update');
Route::delete('/admin/contact/delete/{contact}', 'Admin\Contact\ContactController@delete');
/*
|--------------------------------------------------------------------------
| Shipping
|--------------------------------------------------------------------------
*/

Route::post('/admin/shipping/add', 'Admin\Shipping\ShippingController@create');
Route::delete('/admin/shipping/delete/{shipping}', 'Admin\Shipping\ShippingController@delete');
/*
|--------------------------------------------------------------------------
| Orders
|--------------------------------------------------------------------------
*/

Route::put('/admin/orders/{order}/deny', 'Admin\Order\OrderController@deny');

/*
|--------------------------------------------------------------------------
| Banner
|--------------------------------------------------------------------------
*/

Route::post('/admin/banner/create', 'Admin\Banner\BannerController@create');
Route::delete('/admin/banner/delete/{banner}', 'Admin\Banner\BannerController@delete');
/*
|--------------------------------------------------------------------------
| Payment
|--------------------------------------------------------------------------
*/

Route::post('/admin/payment/create', 'Admin\Payment\PaymentController@create');
Route::delete('/admin/payment/delete/{method}', 'Admin\Payment\PaymentController@delete');

/*
|--------------------------------------------------------------------------
| Showcase
|--------------------------------------------------------------------------
*/

Route::post('/admin/showcase/create', 'Admin\Showcase\ShowcaseController@create');
Route::put('/admin/showcase/update_order', 'Admin\Showcase\ShowcaseController@delete');
Route::put('/admin/showcase/show_toggle/{showcase}', 'Admin\Showcase\ShowcaseController@showToggle');
Route::delete('/admin/showcase/delete/{showcase}', 'Admin\Showcase\ShowcaseController@updateOrder');

Route::put('/admin/showcase/update_name/{showcase}', 'Admin\Showcase\ShowcaseEditController@update');
Route::put('/admin/showcase/add_product/{showcase}', 'Admin\Showcase\ShowcaseEditController@storeProduct');

/*
|--------------------------------------------------------------------------
| Utilities
|--------------------------------------------------------------------------
*/
Route::get('/api/get/category', 'Api\GetterController@getCategory');
Route::get('/api/get/products', 'Api\GetterController@getProduct');
Route::get('/api/get/products_dc', 'Api\GetterController@getProductDiscount');
Route::get('/api/get/products_paginate', 'Api\GetterController@getProductPagination');
Route::get('/api/get/products/{product}', 'Api\GetterController@getProductData');
Route::get('/api/get/code', 'Api\GetterController@getCode');
Route::get('/api/get/contact', 'Api\GetterController@getContact');
Route::get('/api/get/shipping', 'Api\GetterController@getShipping');
Route::get('/api/get/check_email/{email}', 'Api\GetterController@checkEmail');
Route::get('/api/get/redeem/{code}', 'Api\GetterController@redeemCode');
Route::get('/api/get/banner', 'Api\GetterController@getBanner');
Route::get('/api/get/order', 'Api\GetterController@getOrder');
Route::get('/api/get/order/{order}', 'Api\GetterController@getSpecificOrder');
Route::get('/api/get/payment_methods', 'Api\GetterController@getPaymentMethod');
Route::get('/api/get/showcase', 'Api\GetterController@getShowcase');
Route::get('/api/get/showcase/{showcase}', 'Api\GetterController@getSpecificShowcase');

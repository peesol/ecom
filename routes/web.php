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

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/product/{product}', 'Shop\ProductController@index')->name('productPage');


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin', 'Admin\AdminController@index')->name('adminIndex');
/*
|--------------------------------------------------------------------------
| Product
|--------------------------------------------------------------------------
*/
Route::get('/admin/product', 'Admin\Product\ProductController@index')->name('adminProduct');
Route::get('/admin/product/upload', 'Admin\Product\ProductController@uploadPage');
Route::post('/admin/product/create', 'Admin\Product\ProductController@create');
Route::delete('/admin/product/delete/{product}', 'Admin\Product\ProductController@delete');
/*
|--------------------------------------------------------------------------
| Stock
|--------------------------------------------------------------------------
*/
Route::get('/admin/stock', 'Admin\Product\StockController@index');
Route::put('/admin/stock/{product}', 'Admin\Product\StockController@update');
/*
|--------------------------------------------------------------------------
| Photo
|--------------------------------------------------------------------------
*/
Route::get('/admin/product/{product}/edit', 'Admin\Product\EditController@index');
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
|--------------------------------------------------------------------------
| Prommotions
|--------------------------------------------------------------------------
*/
Route::get('/admin/promotions', 'Admin\Promotion\PromotionController@index');
Route::get('/admin/promotions/discount', 'Admin\Promotion\DiscountController@index');
Route::put('/admin/promotions/discount/{product}/apply', 'Admin\Promotion\DiscountController@applyDiscount');
Route::put('/admin/promotions/discount/{product}/cancle', 'Admin\Promotion\DiscountController@cancleDiscount');

Route::get('/admin/promotions/code', 'Admin\Promotion\CodeController@index');
Route::post('/admin/promotions/code/create', 'Admin\Promotion\CodeController@create');
Route::delete('/admin/promotions/code/delete/{id}', 'Admin\Promotion\CodeController@delete');
/*
|--------------------------------------------------------------------------
| Category
|--------------------------------------------------------------------------
*/
Route::get('/admin/category', 'Admin\Category\CategoryController@index');
Route::post('/admin/category/add', 'Admin\Category\CategoryController@create');
Route::put('/admin/category/update', 'Admin\Category\CategoryController@update');
Route::delete('/admin/category/delete/{category}', 'Admin\Category\CategoryController@delete');

/*
|--------------------------------------------------------------------------
| Utilities
|--------------------------------------------------------------------------
*/
Route::get('/api/get/category', 'Api\GetterController@getCategory');
Route::get('/api/get/products', 'Api\GetterController@getProduct');
Route::get('/api/get/products_dc', 'Api\GetterController@getProductDiscount');
Route::get('/api/get/products_paginate', 'Api\GetterController@getProductPagination');
Route::get('/api/get/code', 'Api\GetterController@getCode');

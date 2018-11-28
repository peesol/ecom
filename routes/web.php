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
Route::get('/admin', 'Admin\AdminController@index')->name('adminIndex');

//Products
Route::get('/admin/product', 'Admin\Product\ProductController@index')->name('adminProduct');
Route::get('/admin/product/upload', 'Admin\Product\ProductController@uploadPage');
Route::post('/admin/product/create', 'Admin\Product\ProductController@create');

Route::get('/admin/category', 'Admin\Category\CategoryController@index');
Route::post('/admin/category/add', 'Admin\Category\CategoryController@create');
Route::put('/admin/category/update', 'Admin\Category\CategoryController@update');
Route::delete('/admin/category/delete/{category}', 'Admin\Category\CategoryController@delete');


//Utility
Route::get('/api/get/category', 'Api\GetterController@getCategory');
Route::get('/api/get/products', 'Api\GetterController@getProduct');

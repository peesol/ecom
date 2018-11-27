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
Route::get('/admin/product', 'Admin\ProductController@index')->name('adminProduct');
Route::get('/admin/product/category', 'Admin\ProductController@categoryPage');
Route::post('/admin/product/category/add', 'Admin\ProductController@addCategory');
Route::get('/admin/product/upload', 'Admin\ProductController@uploadPage');

//Utility
Route::get('/api/get/category', 'Api\GetterController@getCategory');

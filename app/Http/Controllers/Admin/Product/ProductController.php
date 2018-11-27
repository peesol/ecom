<?php

namespace App\Http\Controllers\Admin\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
  public function index()
  {
    return view('admin.product.index');
  }
  public function uploadPage()
  {
    return view('admin.product.upload');
  }
}

<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StockController extends Controller
{
  public function index()
  {
    return view('admin.product.stock');
  }
  public function update(Request $request, Product $product)
  {
    $product->update([
      'stock' => $request->stock
    ]);
  }
}

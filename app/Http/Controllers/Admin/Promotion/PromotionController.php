<?php

namespace App\Http\Controllers\Admin\Promotion;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromotionController extends Controller
{
  public function index()
  {
    return view('admin.promotion.index');
  }

  public function applyDiscount(Product $product, Request $request)
  {
    $product->update([
      'discount_price' => $request->discount
    ]);
    $product->save();

    return response()->json($product);
  }

  public function cancleDiscount(Product $product, Request $request)
  {
    $product->update([
      'discount_price' => null
    ]);
    $product->save();
    
    return ;
  }
}

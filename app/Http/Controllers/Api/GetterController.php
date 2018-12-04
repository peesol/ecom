<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\{Category, Product};
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;

class GetterController extends Controller
{
  public function getCategory()
  {
    $data = Category::with('subcategory')->get();

    return response()->json($data);
  }
  public function getProduct(Request $request)
  {
    $data = Product::filter($request)->get();

    return response()->json($data);
  }
  public function getProductDiscount(Request $request)
  {
    $products = Product::filter($request)->whereNull('discount_price')->get();
    $discount = Product::whereNotNull('discount_price')->get();
    $data = [
      'products' => $products,
      'discount' => $discount
    ];
    return response()->json($data);
  }
  public function getProductPagination(Request $request)
  {
    $data = Product::filter($request)->with('category', 'subcategory')->paginate(30);
    return new ProductResource($data);
  }
}

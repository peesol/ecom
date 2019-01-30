<?php

namespace App\Http\Controllers\Api;

use DB;
use Illuminate\Http\Request;
use App\Models\{Category, Product, Shipping, Order};
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

  public function getProductData(Product $product)
  {
    return response()->json($product);
  }

  public function getCode()
  {
    $data = DB::table('codes')->get();
    return response()->json($data);
  }

  public function getContact()
  {
    $data = DB::table('contacts')->get();
    return response()->json($data);
  }

  public function getShipping()
  {
    $data = Shipping::all();
    return response()->json($data);
  }

  public function getOrder()
  {
    $data = Order::all();
    return response()->json($data);
  }

  public function getSpecificOrder(Order $order)
  {
    return response()->json($order);
  }

  public function checkEmail($email)
  {
    (bool) $check = DB::table('users')->where('email',  $email)->count();

    return response($check);
  }

  public function redeemCode($code)
  {
    $result = DB::table('codes')->where('code', $code)->where('enabled', true)->get();
    if ($result->count()) {
      return response()->json($result[0]);
    } else {
      return response()->json(null, 404);
    }

  }

  public function getBanner()
  {
    $data = DB::table('banners')->get();

    return response()->json($data);
  }
}

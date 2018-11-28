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
    $data = Product::filter($request)->with('category', 'subcategory')->paginate(30);
    return new ProductResource($data);
  }
}

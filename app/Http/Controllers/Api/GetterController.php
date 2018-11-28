<?php

namespace App\Http\Controllers\Api;

use App\Models\{Category, Product};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetterController extends Controller
{
  public function getCategory()
  {
    $data = Category::with('subcategory')->get();

    return response()->json($data);
  }

  public function getProduct(Request $request)
  {
    $query = $request->query();
    $data = Product::with('category', 'subcategory')->get();

    return response()->json($data);
  }
}

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
    if ($request->query('c') && !$request->query('sub')) {

      $data = Product::where('category_id', $request->query('c'))->with('category', 'subcategory')->paginate(30);

    } elseif ($request->query('c') && $request->query('sub')) {

      $data = Product::where([
        'category_id' => $request->query('c'),
        'subcategory_id' => $request->query('sub'),
        ])->whereBetween('price', [ $request->query('min'), $request->query('max') ])->with('category', 'subcategory')->paginate(30);

    } else {
      $data = Product::with('category', 'subcategory')->paginate(30);
    }

    return new ProductResource($data);
  }
}

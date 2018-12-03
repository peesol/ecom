<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChoiceController extends Controller
{
  public function get(Product $product)
  {
    if (!$product->choice) {
      $data = [];
    } else {
      $data = $product->choice;
    }
    return response()->json($data);
  }

  public function create(Request $request, Product $product)
  {
    $product->update([
      'choice' => $request->choices
    ]);
    return;
  }

  public function delete(Request $request, Product $product)
  {
    $product->update([
      'choice' => $request->choices
    ]);
    return;
  }
}

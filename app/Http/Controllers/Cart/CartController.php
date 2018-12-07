<?php

namespace App\Http\Controllers\Cart;

use Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
  public function get(Request $request)
  {
    $items = Cart::getContent();
    $data = [];
    foreach ($items as $item) {
      $data[] = $item;
    }

    return response()->json($data);
  }

  public function index()
  {
    return;
  }

  public function addToCart(Product $product, Request $request)
  {
    // $data = array_merge($request->product, [
    //   'attributes' =>  [
    //     'choice' => $request->choice ? $request->choice : null
    //   ],
    //   'quantity' =>  1,
    // ]);
    $price = $request->input('product.discount_price') ? $request->input('product.discount_price') : $request->input('product.price');
    Cart::add([
      'id' => $request->input('product.id'),
      'name' => $request->input('product.name'),
      'price' => $price,
      'quantity' => 1,
      'attributes' => [
        'choice' => $request->input('choice'),
        'thumbnail' => $request->input('product.thumbnail'),
      ]
    ]);

    return;
  }

  public function clear()
  {
    Cart::clear();
    return;
  }
}

<?php

namespace App\Http\Controllers\Cart;

use Auth;
use Cart;
use App\Models\{Product, Shipping};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
  public function get(Request $request)
  {
    $items = Cart::content()->toArray();

    return response()->json(array_values($items));
  }

  public function index()
  {
    $user = Auth::user();
    $shippings = Shipping::all();

    return view('cart.cart', [
      'user' => $user,
      'shippings' => $shippings
    ]);
  }

  public function addToCart(Product $product, Request $request)
  {
    $price = $request->input('product.discount_price') ? $request->input('product.discount_price') : $request->input('product.price');
    Cart::add([
      'id' => $request->input('product.id'),
      'name' => $request->input('product.name'),
      'price' => $price,
      'qty' => 1,
      'options' => [
        'choice' => $request->input('choice'),
        'thumbnail' => $request->input('product.thumbnail'),
      ]
    ]);

    return;
  }

  public function updateQty(Request $request)
  {
    Cart::update($request->rowId, [
      'qty' => (int) $request->qty
    ]);

    return response(Cart::content());
  }

  public function removeFromCart(Request $request)
  {
    Cart::remove($request->rowId);

    return;
  }

  public function clear()
  {
    Cart::destroy();
    return;
  }
}

<?php

namespace App\Http\Controllers\Shop;

use Auth;
use App\Models\{Product, Shipping};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
  public function index(Product $product)
  {
    return view('product.show', ['product' => $product]);
  }

  public function buyNow(Product $product, $choice)
  {
    $product = [
      'id' => $product->id,
      'name' => $product->name,
      'options' => [
        'thumbnail' => $product->filename,
        'choice' => $choice == 'empty' ? null : $choice,
      ],
      'price' => $product->discount_price ? $product->discount_price : $product->price,
      'qty' => 1,
    ];
    $shippings = Shipping::all();
    $user = Auth::user();

    return view('product.buy', [
      'product' => json_encode([$product]),
      'user' => $user,
      'shippings' => $shippings
    ]);
  }
}

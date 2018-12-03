<?php

namespace App\Http\Controllers\Admin\Product;

use Image;
use Storage;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditController extends Controller
{
  public function index(Product $product)
  {
    return view('admin.product.edit', ['product' => $product]);
  }

  public function update(Request $request, Product $product)
  {
    $product->name = $request->name;
    $product->price = $request->price;
    $product->description = $request->description;
    $product->visibility = $request->visibility;
    if (!empty($request->thumbnail)) {
        if (!empty($product->thumbnail)) {
          Storage::disk('public')->delete('/product/thumbnail/' . $product->thumbnail);
        }
        $thumbnail = $request->thumbnail;

        $fileName = uniqid('p_thumb');

        $exploded = explode(',', $thumbnail);

        $decoded = base64_decode($exploded[1]);

        //Crop images
        $background = Image::canvas(200, 200, '#ffffff');
        $img = Image::make($decoded)->encode('jpg', 10)->resize(200, 200, function ($c) {
            $c->upsize();
            $c->aspectRatio();
        });
        $background->insert($img, 'center');
        $img = $background->stream();
        Storage::disk('public')->put('/product/thumbnail/' . $fileName . '.jpg', $img);

        $product->thumbnail = $fileName . '.jpg';
    }

    $product->save();
    return response()->json(null, 200);
  }

}

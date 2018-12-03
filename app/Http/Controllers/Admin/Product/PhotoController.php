<?php

namespace App\Http\Controllers\Admin\Product;

use Image;
use Storage;
use App\Models\{Product, ProductImage};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhotoController extends Controller
{
  public function get(Product $product)
  {
    $data = $product->getImage();
    return response()->json($data);
  }

  public function upload(Request $request, Product $product)
  {
    if(ProductImage::where('product_id', $product->id)->count() < 6) {
    $photos = [];
    $response = [];

    foreach ($request->file('image') as $image) {
      $photo = uniqid('p_img_');
      //Crop image
      $background = Image::canvas(500, 500, '#ffffff');
      $img = Image::make($image)->encode('jpg')->resize(500, 500, function ($c) {
          $c->aspectRatio();
          $c->upsize();
      });

      $background->insert($img, 'center');
      $img = $background->stream();
      Storage::disk('public')->put('/product/photo/' . $photo . '.jpg', $img->__toString());
      ProductImage::create([
        'product_id' => $product->id,
        'filename' => $photo . '.jpg',
      ]);
    }

    return response()->json();

    } else {
      return false;
    }
}

  public function delete($id)
  {
    $photo = ProductImage::find($id);
    $path = '/product/photo/' . $photo->filename;
    Storage::disk('public')->delete($path);
    $photo->delete();

    return ;
  }
}

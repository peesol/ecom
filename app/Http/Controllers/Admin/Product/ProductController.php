<?php

namespace App\Http\Controllers\Admin\Product;

use Image;
use Storage;
use Carbon\Carbon;
use App\Models\{Product, ProductImage};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
  public function index()
  {
    $products = Product::all();
    return view('admin.product.index', ['products' => $products]);
  }

  public function uploadPage()
  {
    return view('admin.product.upload');
  }

  public function create(Request $request)
  {
    $subcategory_id = $request->subcategory_id == 'null' ? '1' : $request->subcategory_id;
    $uid = uniqid('p_');
    $thumbnail = uniqid('p_thumb_');
    $created = Product::create([
      'uid' => $uid,
      'name' => $request->name,
      'category_id' => $request->category_id,
      'subcategory_id' => $subcategory_id,
      'price' => $request->price,
      'description' => $request->description,
      'visibility' => 'public',
      'thumbnail' => $thumbnail . '.jpg',
      'choice' => json_encode([
        $request->choices
      ])
    ]);

    $images =  $request->file('image');
    if ($images[0]) {
      $fileName = uniqid('p_thumb');
      //Crop image
      $background = Image::canvas(200, 200, '#ffffff');
      $img = Image::make($images[0])->encode('jpg', 10)->resize(200, 200, function ($c) {
          $c->upsize();
          $c->aspectRatio();
      });
      $background->insert($img, 'center');
      $img = $background->stream();
      Storage::disk('public')->put('/product/thumbnail/' . $fileName . '.jpg', $img->__toString());
    }

    foreach ($images as $image) {
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
        'product_id' => $created->id,
        'filename' => $photo . '.jpg',
      ]);
    }

    return ;
  }

  public function delete(Request $request, Product $product)
  {
    $product->delete();

    return ;
  }
}

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

  public function editPage(Product $product)
  {
    return view('admin.product.edit', ['product' => $product]);
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
    ]);

    $images =  $request->file('image');
    if ($images[0]) {
      $img = Image::make($images[0])->fit(200)->encode('jpg');
      Storage::disk('public')->put('/product/thumbnail/' . $thumbnail . '.jpg', $img->__toString());
    }

    foreach ($images as $image) {
      $photo = uniqid('p_img_');
      $img = Image::make($image)->fit(500)->encode('jpg');
      Storage::disk('public')->put('product/photo/' . $photo . '.jpg', $img->__toString());
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

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
  public function index()
  {
    return view('admin.product.index');
  }
  public function uploadPage()
  {
    return view('admin.product.upload');
  }

  public function categoryPage()
  {
    $data = Category::with('subcategory')->get();

    return view('admin.product.category', ['categories' => $data]);
  }

  public function addCategory(Request $request)
  {
    $created = Category::create([
      'name' => $request->category_name
    ]);
    // create subcategory if has one
    if ($request->hasSub) {
      foreach ($request->subs as $sub) {
        $created->subcategory()->create([
          'name' => $sub,
        ]);
      }
    }

    return response()->json($created->load('subcategory'));
  }
}

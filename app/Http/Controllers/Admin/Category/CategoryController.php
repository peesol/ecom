<?php

namespace App\Http\Controllers\Admin\Category;

use App\Models\{Category, Subcategory};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
  public function index()
  {
    $data = Category::with('subcategory')->get();

    return view('admin.category.index', ['categories' => $data]);
  }

  public function create(Request $request)
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

  public function update(Request $request)
  {
    Category::find($request->category['id'])->update([
      'name' => $request->category['name']
    ]);
    if ($request->category['subcategory']) {
      foreach ($request->category['subcategory'] as $sub) {
        Subcategory::where('id', $sub['id'])->update([
          'name' => $sub['name']
        ]);
      }
    }
    return ;
  }

  public function delete(Category $category)
  {
    $category->delete();

    return ;
  }
}

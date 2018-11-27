<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetterController extends Controller
{
  public function getCategory()
  {
    $data = Category::with('subcategory')->get();

    return response()->json($data);
  }
}

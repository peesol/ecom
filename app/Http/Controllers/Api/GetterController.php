<?php

namespace App\Http\Controllers\Api;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetterController extends Controller
{
  public function getCategory()
  {
    $data = DB::table('categories')->get();

    return response()->json($data);
  }
}

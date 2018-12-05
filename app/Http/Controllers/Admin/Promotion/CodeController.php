<?php

namespace App\Http\Controllers\Admin\Promotion;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CodeController extends Controller
{
  public function index()
  {
    return view('admin.promotion.code');
  }

  public function create(Request $request)
  {
    $id = DB::table('codes')->insertGetId([
      'code' => $request->form['code'],
      'value' => $request->form['value'],
      'type' => $request->form['type']
    ]);
    $response = array_add($request->form, 'id', $id);
    return response()->json($response);
  }

  public function delete($id)
  {
    DB::table('codes')->where('id', $id)->delete();

    return;
  }
}

<?php

namespace App\Http\Controllers\Admin\Shipping;

use App\Models\Shipping;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShippingController extends Controller
{
  public function index()
  {
    return view('admin.shipping.index');
  }

  public function create(Request $request)
  {
    $created = Shipping::create([
      'method' => $request->method,
      'fee' => $request->fee,
      'multiply' => $request->multiply,
      'promotion' => $request->promotion
    ]);

    return response()->json($created);
  }

  public function delete(Shipping $shipping, Request $request)
  {
    $shipping->delete();

    return;
  }
}

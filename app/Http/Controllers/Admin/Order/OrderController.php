<?php

namespace App\Http\Controllers\Admin\Order;

use App\Models\{Order};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
  public function deny(Order $order, Request $request)
  {
    $order->update([
      'cancle' => $request->message
    ]);

    return ;
  }
}

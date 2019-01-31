<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Models\{Order, PaymentMethod};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
  public function create(Request $request)
  {
    $created = PaymentMethod::create([
      'ref' => $request->ref,
      'method' => $request->method,
      'provider' => $request->provider,
    ]);

    return response()->json($created);
  }

  public function transaction(Order $order)
  {
    return view('order.payment._transaction', [
      'order' => $order,
      'accounts' => PaymentMethod::all()
    ]);
  }

  public function confirmTransaction(Order $order, Request $request)
  {
    $order->update([
      'date_paid' => $request->provider . ' ' . $request->date . '-' . $request->time,
      'status' => [
        'paid' => true,
        'shipped' => false,
        'delivered' => false
      ],
    ]);

    return redirect()->back();
  }
}

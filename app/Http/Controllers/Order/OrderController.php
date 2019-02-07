<?php

namespace App\Http\Controllers\Order;

use Auth;
use Carbon\Carbon;
use App\Models\{Order, User, PaymentMethod};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
  public function index()
  {
    $orders = Auth::user()->order;

    return view('order.index', ['orders' => $orders]);
  }

  public function orderView(Order $order)
  {
    return view('order.order', ['order' => $order]);
  }

  public function paymentView(Order $order)
  {
    return view('order.payment',
      [
        'order' => $order,
        'payments' => PaymentMethod::all()
      ]);
  }

  public function create(Request $request)
  {
    $user = User::find(Auth::id());
    $time = Carbon::now()->format('dmYHis');
    $created = Order::create([
      'user_id' => $user->id,
      'title' => $request->name . ' ' . Carbon::now()->format('d-m-Y'),
      'uid' => $time . '0' . $user->id,
      'body' => $request->body,
      'total' => $request->total,
      'discount' => $request->discount,
      'shipping' => $request->shipping,
      'fee' => $request->fee,
      'address' => $request->name . ' ' . $request->address . ' tel.' . $request->phone,
      'status' => [
        'paid' => false,
        'shipped' => false,
        'delivered' => false
      ],
    ]);

    if ($user->address == null) {
      $user->update([
        'phone' => $request->phone,
        'address' => $request->address
      ]);
      $user->save();
    }
    return response($created);
  }
}

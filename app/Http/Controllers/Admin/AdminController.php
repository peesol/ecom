<?php

namespace App\Http\Controllers\Admin;

use DB;
use Carbon\Carbon;
use App\Models\{Order, Product};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
  public function index()
  {
    return view('admin.index');
  }

  public function getData()
  {
    $orders = Order::all();
    $count = Order::whereMonth('created_at', Carbon::now()->month)->count();
    $monthly = [];
    $yearly = [];
    $salesByMonth = [];
    foreach ($orders as $order) {
      if ($order->status['paid'] && !$order->cancle) {
        $salesByMonth[] = [
          'total' => $order->total,
          'created_at' => $order->created_at,
        ];
        if ($order->created_at->month == Carbon::now()->month) {
          $monthly[] = $order;
        }
        if ($order->created_at->year == Carbon::now()->year) {
          $yearly[] = $order;
        }
      }
    }

    $months = collect($salesByMonth);
    $months = $months->sortBy('created_at')->groupBy( function($item, $key) {
        return date_format($item['created_at'], "M");
    });
    $monthlySales = [];
    foreach ($months as $key => $month) {
      $total = [];
      foreach ($month as  $value) {
        $total[] = $value['total'];
      }
      $monthlySales[$key] = array_sum($total);
    }


    $sales = [
      // 'orders' => Order::whereMonth('created_at', Carbon::now()->month)->get(),
      'count' => $count,
      'monthly' => $monthly,
      'yearly' => $yearly,
      'graph' => $monthlySales,
      'products' => Product::orderBy('view_count', 'desc')->orderBy('updated_at')->take(10)->get(),
    ];

    return response()->json($sales);
  }
}

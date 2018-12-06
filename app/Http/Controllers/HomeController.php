<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $banners = [
        asset('file/banner/1.jpeg'),
        asset('file/banner/2.jpeg'),
        asset('file/banner/3.jpeg'),
      ];

      //$products = DB::table('products')->get();
      $products = Product::whereNull('discount_price')->get();
      $promotion = Product::whereNotNull('discount_price')->get();

      return view('home', [
        'banners' => json_encode($banners),
        'products' => $products,
        'promotion' => $promotion,
      ]);
    }
}

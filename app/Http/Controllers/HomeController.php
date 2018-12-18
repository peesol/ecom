<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\{Product, Banner};

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
    public function home()
    {
      $banners = Banner::all();
      $products = Product::whereNull('discount_price')->take(10)->get();
      $promotion = Product::whereNotNull('discount_price')->take(10)->get();

      return view('home', [
        'banners' => $banners,
        'products' => $products,
        'promotion' => $promotion,
      ]);
    }

    public function shop()
    {
      return view('shop');
    }

    public function contact()
    {
      return view('contact');
    }
}

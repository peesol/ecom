<?php

namespace App\Http\Controllers\Admin\Promotion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromotionController extends Controller
{
  public function index()
  {
    return view('admin.promotion.index');
  }
}

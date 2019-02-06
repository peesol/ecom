<?php

namespace App\Http\Controllers\User;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
  public function index()
  {
    return view('user.profile', ['user' => Auth::user()]);
  }

  public function edit()
  {
    return view('user.edit', ['user' => Auth::user()]);
  }

  public function update(Request $request)
  {
    Auth::user()->update([
      'name' => $request->name,
      'address' => $request->address,
      'email' => $request->email,
      'phone' => $request->phone
    ]);

    return redirect('/profile');
  }
}

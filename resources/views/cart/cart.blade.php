@extends('app.layout')
@section('content')
  <div class="panel-head medium">
    <h1><i class="fas fa-shopping-cart"></i>&nbsp;Cart</h1>
  </div>
  <div class="panel medium">
    <cart :user-data="{{ $user }}" :shippings="{{ $shippings }}" view="cart"></cart>
  </div>
@endsection

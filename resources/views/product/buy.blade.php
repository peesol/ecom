@extends('app.layout')
@section('content')
  <div class="panel-head medium">
    <h1>Buy now</h1>
  </div>
  <div class="panel medium">
    <cart :user-data="{{ $user }}" :shippings="{{ $shippings }}" view="buynow" :product-prop="{{ $product }}"></cart>
  </div>
@endsection

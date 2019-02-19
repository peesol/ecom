@extends('app.layout')
@section('content')
  <h1><i class="fas fa-shopping-cart"></i>&nbsp;Cart</h1>
  <cart :user-data="{{ $user }}" :shippings="{{ $shippings }}" view="cart"></cart>
@endsection

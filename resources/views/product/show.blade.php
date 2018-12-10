@extends('app.layout')
@section('content')
  <section>
    <div class="panel medium padding-15-v col-2-flex-res">
      <div class="half-width-res padding-15-right-screen">
        <img-slick :imgs="{{ $product->images }}"></img-slick>
      </div>
      <div class="half-width-res padding-15-screen">
        <h1 class="padding-5-bottom">{{ $product->name }}</h1>
        @if (!$product->discount_price)
          <h3 class="padding-5-v">{{ number_format($product->price) }}&nbsp;THB</h3>
        @else
          <h3 class="padding-5-v"><s>{{ number_format($product->price) }}</s>&nbsp;{{ number_format($product->discount_price) }}&nbsp;THB</h3>
        @endif
        <p class="padding-5-v">{{ $product->description }}</p>
        <add-to-cart :product-data="{{ $product }}"></add-to-cart>
      </div>
    </div>
  </section>
@endsection

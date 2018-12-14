@extends('app.layout')
@section('content')
  <div class="panel-head medium">
    <h1>Order</h1>
    <h2>#{{ $order->uid }}</h2>
    <p>Address<br>{{ $order->address }}</p>
  </div>
  <div class="panel medium padding-10">
    @if ($order->status['paid'])
      PAID
    @else
      NOT YET PAID
    @endif
    @if ($order->status['paid'] && $order->status['shipped'])
      Shipped
    @elseif ($order->status['paid'] && !$order->status['shipped'])
      Preparing for shipping
    @endif
  </div>
  <div class="panel medium">
    <div class="order">
      @foreach ($order->body as $item)
        <div class="product">
          <div class="thumbnail">
            <img src="{{ url('/file/product/thumbnail/'.$item['options']['thumbnail']) }}" alt="img">
          </div>
          <div class="details full-width">
            <div class="name">{{ $item['name'] }}</div>
            <div class="choice">{{ $item['options']['choice'] ? $item['options']['choice'] : '' }}</div>
            <div class="price">
              {{ number_format($item['price']) }}&nbsp;THB &times; {{ $item['qty'] }}<br>
              <strong class="font-green">{{ number_format($item['subtotal']) }}</strong>&nbsp;THB
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <section class="grey padding-10">
      @if ($order->discount)
        <h2>{{ number_format($order->discount) }}&nbsp;THB</h2>
      @else
        <h2>{{ number_format($order->total) }}&nbsp;THB</h2>
      @endif
      <p>Shipping fee: {{ $order->shipping['fee'] }}&nbsp;THB</p>
    </section>
  </div>
@endsection

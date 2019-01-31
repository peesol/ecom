@extends('app.layout')
@section('content')
<div class="panel-head medium">
    <h2>รายการสั่งซื้อ</h2>
    <h3>#{{ $order->uid }}</h3>
    <p>ที่อยู่ในการจัดส่ง<br>{{ $order->address }}</p>
</div>
<div class="grid-x">
  @if (!$order->status['paid'])
    <label class="status warning">ยังไม่ชำระเงิน</label>
    <button class="margin-15-left btn primary" onclick="document.location.href='{{ route('payment', ['order' => $order->uid]) }}'">ชำระเงินที่นี่</button>
  @endif
  @if ($order->status['paid'] && $order->status['shipped'])
  <label class="status success">ส่งสินค้าแล้ว</label>
  @elseif ($order->status['paid'] && !$order->status['shipped'])
  <label class="status success">เตรียมจัดส่ง</label>
  @endif
</div>
<table class="stack unstriped margin-15-v">
  <thead>
    <tr>
      <th>สินค้า</th>
      <th>ราคา</th>
    </tr>
  </thead>
    <tbody>
      @foreach ($order->body as $item)
        <tr>
            <td>
              <img src="{{ url('/file/product/thumbnail/'.$item['options']['thumbnail']) }}" alt="img" style="width:60px;margin-right:8px">
              {{ $item['name'] }}{{ ' - ' . $item['options']['choice'] ? $item['options']['choice'] : '' }}
            </td>
            <td><font class="show-for-small-only">ราคา</font> {{ number_format($item['price']) }}&nbsp;THB &times; {{ $item['qty'] }}</td>
        </tr>
      @endforeach
        <tr>
          <td colspan="2">
            @if ($order->discount)
            <h3 class="font-green">ยอดชำระ {{ number_format($order->discount) }}&nbsp;THB</h3>
            @else
            <h3 class="font-green">ยอดชำระ {{ number_format($order->total) }}&nbsp;THB</h3>
            @endif
            <p class="no-margin">ค่าจัดส่งสินค้า {{ $order->fee }}</p>
          </td>
        </tr>
    </tbody>
</table>
@endsection

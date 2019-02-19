@extends('app.layout')
@section('content')
<h2>รายการสั่งซื้อ</h2>
<table class="stack unstriped">
  <thead>
    <tr>
      <th>หมายเลข</th>
      <th>วันที่สั่ง</th>
      <th>ยอดชำระ</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($orders as $order)
      <tr>
        <td>
          <a href="/order/{{ $order->uid }}">#{{ $order->uid }}</a>
        </td>
        <td><font class="show-for-small-only font-bold">วันที่สั่ง </font>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</td>
        <td><font class="show-for-small-only font-bold">ยอดชำระ </font>{{ number_format($order->total) }}</td>
      </tr>
    @endforeach
  </tbody>
</table>


@endsection

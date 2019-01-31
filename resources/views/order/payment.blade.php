@extends('app.layout')
@section('content')
<h2>ชำระเงิน</h2>
<section class="transaction">
  <h3>โอนเงิน</h3>
  <p>เมื่อทำการโอนเงินแล้วโปรดทำการแจ้งชำระเงิน&nbsp;<a href="{{ url('/order/'.$order->uid.'/payment/notify') }}">คลิกที่นี่</a></p>
  <table class="stack margin-15-v">
    <thead>
      <tr>
        <th>บัญชีธนาคาร</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($payments as $method)
        <tr>
          <td>{{ $method->provider }}
            @if ($method->method == 'PromptPay')
              &nbsp;<small class="label">PromptPay</small>
            @endif
            <p class="no-margin">{{ $method->ref }}</p>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</section>
@endsection

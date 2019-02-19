@extends('app.layout')
@section('content')
  @if ($order->status['paid'])
    <div class="text-center" style="padding:100px 0">
      <h3>รายการนี้ได้แจ้งชำระเงินแล้ว</h3>
      <a class="lead" href="{{ url('/order/'.$order->uid) }}">กลับหน้ารายการนี้</a>
    </div>
  @else
    <h2>แจ้งชำระเงิน</h2>
    <p class="no-margin">หมายเลขรายการสั่งซื้อ</p>
    <h4>#{{ $order->uid }}</h4>
    <form class="grid-x" action="{{ route('confirmTransaction', ['order' => $order->uid]) }}" method="post">
      <div class="form-group cell medium-5">
        <label>ธนาคาร</label>
        <select required name="provider">
          @foreach ($accounts as $account)
            <option value="{{ $account->provider }}">{{ $account->provider }}{{ $account->method == 'PromptPay' ? '*PromptPay' : '' }}</option>
          @endforeach
        </select>
        <label>
          เวลาที่โอน
          <small class="subheader">ตัวอย่าง 01/05/2561</small>
        </label>
        <div class="grid-x padding-15-bottom">
          <input required class="small-12 medium-4" type="text" name="date" placeholder="วว/ดด/ปปปป">
          <input required class="small-12 medium-2" type="text" name="time" placeholder="00:00">
          <button class="btn success small-12 medium-auto align-self-top" type="submit" name="button">แจ้งชำระเงิน</button>
        </div>
      </div>
      @csrf
      @method('PUT')
    </form>
  @endif
@endsection

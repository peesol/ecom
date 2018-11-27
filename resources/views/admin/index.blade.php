@extends('admin._admin_layout')
@section('content')
  <div class="border-bottom panel-head small">
    <h1>จัดการหลังร้าน</h1>
  </div>
  <div class="panel small">
    <li class="padding-10-v no-style font-large">
      <a href="{{ url('/admin/product') }}">สินค้า&nbsp;<i class="fas fa-angle-right"></i></a><br>
      <sub>จัดการสินค้า ราคา สต๊อก หรือ โปรโมชั่น</sub>
    </li>
    <li class="padding-10-v no-style font-large">
      <a href="{{ url('/admin/category') }}">หมวดหมู่สินค้า&nbsp;<i class="fas fa-angle-right"></i></a><br>
      <sub>
        จัดการหมวดหมู่สินค้า<br>
        <font class="font-red">*คุณต้องสร้างหมวดหมู่ก่อนที่จะอัพโหลดสินค้า</font>
      </sub>
    </li>
    <li class="padding-10-v no-style font-large">
      <a href="{{ url('') }}">แบนเนอร์&nbsp;<i class="fas fa-angle-right"></i></a><br>
      <sub>จัดการป้ายโฆษณาบนหน้าแรก</sub>
    </li>
    <li class="padding-10-v no-style font-large">
      <a href="{{ url('') }}">ช่องทางชำระเงิน&nbsp;<i class="fas fa-angle-right"></i></a><br>
      <sub>จัดการช่องทางชำระเงินของร้าน</sub>
    </li>
  </div>
@endsection

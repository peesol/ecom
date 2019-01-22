@extends('admin._admin_layout')
@section('content')
  <div class="grid-y grid-padding-y panel small small-up-1">
    <div class="cell">
      <h1>จัดการหลังร้าน</h1>
    </div>
    <div class="cell">
      <a class="lead" href="{{ url('/admin/product') }}">สินค้า&nbsp;<i class="fas fa-angle-right"></i></a><br>
      <span>จัดการสินค้า ราคา สต๊อก หรือ โปรโมชั่น</span>
    </div>
    <div class="cell">
      <a class="lead" href="{{ url('/admin/category') }}">หมวดหมู่สินค้า&nbsp;<i class="fas fa-angle-right"></i></a><br>
      <span>
        จัดการหมวดหมู่สินค้า<br>
        <font class="font-red">*คุณต้องสร้างหมวดหมู่ก่อนที่จะอัพโหลดสินค้า</font>
      </span>
    </div>
    <div class="cell">
      <a class="lead" href="{{ url('/admin/promotions') }}">โปรโมชั่น&nbsp;<i class="fas fa-angle-right"></i></a><br>
      <span>จัดการลดราคาสินค้า</span>
    </div>
    <div class="cell">
      <a class="lead" href="{{ url('/admin/banner') }}">แบนเนอร์&nbsp;<i class="fas fa-angle-right"></i></a><br>
      <span>จัดการป้ายโฆษณาบนหน้าแรก</span>
    </div>
    <div class="cell">
      <a class="lead" href="{{ url('/admin/account') }}">ช่องทางชำระเงิน&nbsp;<i class="fas fa-angle-right"></i></a><br>
      <span>จัดการช่องทางชำระเงินของร้าน</span>
    </div>
    <div class="cell">
      <a class="lead" href="{{ url('/admin/shipping') }}">การจัดส่ง&nbsp;<i class="fas fa-angle-right"></i></a><br>
      <span>จัดการช่องทางการจัดส่งและโปรโมชั่นการส่งสินค้า</span>
    </div>
    <div class="cell">
      <a class="lead" href="{{ url('/admin/contact') }}">ข้อมูลของร้าน&nbsp;<i class="fas fa-angle-right"></i></a><br>
      <span>จัดการข้อมูลของร้าน ที่อยู่ หรือ โซเชียลต่างๆ</span>
    </div>
  </div>
@endsection

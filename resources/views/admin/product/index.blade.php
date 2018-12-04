@extends('admin._admin_layout')
@section('content')
<div class="panel-head large border-bottom">
  <h1>จัดการสินค้า</h1>
  <button type="button" name="button" class="btn blue" onclick="document.location.href='{{ route('adminIndex') }}'"><i class="fas fa-angle-left"></i>&nbsp;กลับ</button>
</div>
<div class="panel large border-bottom">
  <button type="button" name="button" class="btn blue" onclick="document.location.href='{{ url('/admin/product/upload') }}'">เพิ่มสินค้า&nbsp;<i class="fas fa-plus"></i></button>
  <button type="button" name="button" class="btn blue" onclick="document.location.href='{{ url('/admin/stock') }}'">สต๊อก</button>
  <button type="button" name="button" class="btn blue" onclick="document.location.href='{{ url('/admin/promotions') }}'">โปรโมชั่น</button>
</div>
<div class="panel large round relative">
  <load-overlay bg="white-bg" :show="$root.loading"></load-overlay>
  <product-show></product-show>
</div>
@endsection

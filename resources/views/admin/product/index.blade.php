@extends('admin._admin_layout')
@section('content')
<div class="panel-head large border-bottom">
  <h1>จัดการสินค้า</h1>
  <button type="button" name="button" class="btn blue" onclick="document.location.href='{{ route('adminIndex') }}'"><i class="fas fa-angle-left"></i>&nbsp;กลับ</button>
</div>
<div class="panel large">
  <button type="button" name="button" class="btn blue" onclick="document.location.href='{{ url('/admin/product/upload') }}'">เพิ่มสินค้า&nbsp;<i class="fas fa-plus"></i></button>
</div>
<div class="panel large round">

</div>
@endsection

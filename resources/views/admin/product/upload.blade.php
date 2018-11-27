@extends('admin._admin_layout')
@section('content')
<div class="panel-head small round border-bottom">
  <h1>เพิ่มสินค้า</h1>
  <button type="button" name="button" class="btn blue" onclick="document.location.href='{{ route('adminProduct') }}'"><i class="fas fa-angle-left"></i>&nbsp;กลับ</button>
</div>
<div class="panel small round">
  <product-upload></product-upload>
</div>
@endsection

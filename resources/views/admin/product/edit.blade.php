@extends('admin._admin_layout')
@section('content')
<div class="panel-head large border-bottom">
  <h1>แก้ไขสินค้า</h1>
  <button type="button" name="button" class="btn blue" onclick="document.location.href='{{ route('adminIndex') }}'"><i class="fas fa-angle-left"></i>&nbsp;กลับ</button>
</div>
<div class="panel large round relative">
  <load-overlay bg="white-bg" :show="$root.loading"></load-overlay>
  <product-edit></product-edit>
</div>
@endsection

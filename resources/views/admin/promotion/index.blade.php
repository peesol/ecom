@extends('admin._admin_layout')
@section('content')
<div class="panel-head medium border-bottom">
  <h1>จัดการโปรโมชั่น</h1>
  <button type="button" name="button" class="btn blue" onclick="document.location.href='{{ route('adminProduct') }}'"><i class="fas fa-angle-left"></i>&nbsp;กลับ</button>
</div>
<div class="panel medium round relative">
  <load-overlay bg="white-bg" :show="$root.loading"></load-overlay>
  <product-discount></product-discount>
</div>
@endsection

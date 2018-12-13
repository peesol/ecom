@extends('admin._admin_layout')
@section('content')
<div class="panel-head small round border-bottom">
  <h1>การจัดส่ง</h1>
  <button type="button" name="button" class="btn blue" onclick="document.location.href='{{ route('adminIndex') }}'"><i class="fas fa-angle-left"></i>&nbsp;กลับ</button>
</div>
<div class="panel small round">
  <shipping></shipping>
</div>
@endsection

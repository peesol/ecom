@extends('admin._admin_layout')
@section('content')
<div class="panel-head small border-bottom">
  <h1>แบนเนอร์</h1>
  <button type="button" name="button" class="btn blue" onclick="document.location.href='{{ route('adminIndex') }}'"><i class="fas fa-angle-left"></i>&nbsp;กลับ</button>
</div>
<div class="panel small round relative">
  <load-overlay bg="white-bg" :show="$root.loading"></load-overlay>
  <banner-edit :banner-prop="{{ $banners }}"></banner-edit>
</div>
@endsection

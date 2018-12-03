@extends('admin._admin_layout')
@section('content')
<div class="panel-head large border-bottom">
  <h1>แก้ไขสินค้า</h1>
  <button type="button" name="button" class="btn blue" onclick="document.location.href='{{ route('adminProduct') }}'"><i class="fas fa-angle-left"></i>&nbsp;กลับ</button>
</div>
<div class="panel large round relative">
  <load-overlay bg="white-bg" :show="$root.loading"></load-overlay>
  <product-edit
  product-slug="{{ $product->uid }}"
  product-name="{{ $product->name }}"
  product-price="{{ $product->price }}"
  product-description="{{ $product->description }}"
  product-visibility="{{ $product->visibility }}"
  image-src="{{ $product->getThumbnail() }}"
  ></product-edit>
  <product-photo product-slug="{{ $product->uid }}"></product-photo>
  <product-choice product-slug="{{ $product->uid }}"></product-choice>
</div>
@endsection

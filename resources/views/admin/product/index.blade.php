@extends('admin._admin_layout')
@section('content')
<div class="panel-head large border-bottom">
  <h1>จัดการสินค้า</h1>
  <button type="button" name="button" class="btn blue" onclick="document.location.href='{{ route('adminIndex') }}'"><i class="fas fa-angle-left"></i>&nbsp;กลับ</button>
</div>
<div class="panel large">
  <button type="button" name="button" class="btn blue" onclick="document.location.href='{{ url('/admin/product/upload') }}'">เพิ่มสินค้า&nbsp;<i class="fas fa-plus"></i></button>
  <button type="button" name="button" class="btn blue" onclick="document.location.href='{{ url('/admin/product/upload') }}'">สต๊อก</button>
  <button type="button" name="button" class="btn blue" onclick="document.location.href='{{ url('/admin/product/upload') }}'">โปรโมชั่น</button>
</div>
<div class="panel large round">
  <div class="thumbnail-grid">
    @foreach ($products as $product)
      <div class="thumbnail-wrapper product">
        <img src="{{ $product->getThumbnail() }}" alt="{{ $product->thumbnail }}">
        <p class="title">{{ $product->name }}</p>
        <p class="price">{{ number_format($product->price) }}</p>
        <p class="category">{{ $product->category->name }} / {{ $product->subcategory->name }}</p>
      </div>
    @endforeach
  </div>

</div>
@endsection

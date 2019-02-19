@extends('app.layout')
@section('content')
<div>
  <h2>แก้ไขโปรไฟล์</h2>
</div>
<section>
  <form action="/profile/edit" method="post" class="grid-x">
    <div class="cell medium-6">
      <div class="form-group">
        <label>ชื่อ</label>
        <input type="text" name="name" value="{{ $user->name }}">
      </div>
      <div class="form-group">
        <label>ที่อยู่</label>
        <textarea class="description-input" name="address" rows="8" cols="80">{{ $user->address }}</textarea>
      </div>
      <div class="form-group">
        <label>อีเมล <small>*ไม่สามารถแก้ไขอีเมลได้</small></label>
        <p class="lead">{{ $user->email }}</p>
      </div>
      <div class="form-group">
        <label>โทรศัพท์</label>
        <input type="text" name="phone" value="{{ $user->phone }}">
      </div>
      <div class="grid-x padding-15-bottom align-right">
        <button class="btn success cell medium-3" type="submit" name="button">บันทึก</button>
      </div>
    </div>
    @csrf
    @method('PUT')
  </form>
</section>

@endsection

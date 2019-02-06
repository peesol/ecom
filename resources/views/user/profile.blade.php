@extends('app.layout')
@section('content')
<div>
  <h2>โปรไฟล์ของฉัน</h2>
</div>
<section>
  <div class="margin-15-v">
    <a class="btn primary" href="/profile/edit">แก้ไขโปรไฟล์</a>
  </div>
  <div class="grid-y">
    <h4 class="no-margin">ชื่อ</h4>
    <p class="lead">{{ $user->name }}</p>
    <h4 class="no-margin">ที่อยู่</h4>
    <p class="lead">{{ $user->address }}</p>
    <h4 class="no-margin">อีเมล</h4>
    <p class="lead">{{ $user->email }}</p>
    <h4 class="no-margin">โทรศัพท์</h4>
    <p class="lead">{{ $user->phone }}</p>
  </div>
</section>

@endsection

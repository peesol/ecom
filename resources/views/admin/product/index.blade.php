@extends('admin._admin_layout')
@section('content')
  <div class="mobile-menu">
    <button class="fas fa-angle-left" @click.prevent="$router.go(-1)">&nbsp;ย้อนกลับ</button>
    <button class="fas fa-bars" @click.prevent="$root.menu = !$root.menu"></button>
  </div>
  <transition name="width">
    <div class="menu hide-for-small-only" :class="{'active' : $root.menu}">
      <p class="menu-title">จัดการสินค้า</p>
      <router-link class="fas fa-warehouse" to="/admin/product" exact>สินค้าในร้าน</router-link>
      <router-link class="fas fa-plus" to="/admin/product/upload">เพิ่มสินค้า</router-link>
      <router-link class="fas fa-list" to="/admin/category">หมวดหมู่</router-link>
      <router-link class="fas fa-box" to="/admin/product/stock">สต๊อก</router-link>
      <router-link class="fas fa-tag" to="/admin/promotions/discount">ลดราคาสินค้า</router-link>
      <router-link class="fas fa-receipt" to="/admin/promotions/code">โค๊ดลดราคา</router-link>
      <a class="fas fa-home" href="{{ route('adminIndex') }}">กลับหน้าแรก</a>
    </div>
  </transition>
  <div class="dashboard">
    <div class="grid-container grid-padding-y">
      <load-overlay bg="white-bg" :show="$root.loading"></load-overlay>
      <router-view></router-view>
    </div>
  </div>
@endsection

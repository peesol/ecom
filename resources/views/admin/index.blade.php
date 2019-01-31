@extends('admin._admin_layout')
@section('content')
  <div class="mobile-menu">
    <button class="fas fa-angle-left" @click.prevent="$router.go(-1)">&nbsp;ย้อนกลับ</button>
    <button class="fas fa-bars" @click.prevent="$root.menu = !$root.menu"></button>
  </div>
  <transition name="width">
    <div class="menu hide-for-small-only" :class="{'active' : $root.menu}">
      <p class="menu-title">Admin</p>
      <a class="fas fa-warehouse" href="{{ url('/admin/product') }}">จัดการสินค้า</a>
      <router-link class="fas fa-ad" to="/admin/banner">แบนเนอร์</router-link>
      <router-link class="fas fa-money-check" to="/admin/payment">ช่องทางชำระเงิน</router-link>
      <router-link class="fas fa-truck" to="/admin/shipping">การจัดส่ง</router-link>
      <router-link class="fas fa-list-ul" to="/admin/orders">รายการสั่งซื้อ</router-link>
      <router-link class="fas fa-user-tie" to="/admin/contact">ข้อมูลของร้าน</router-link>
    </div>
  </transition>
  <div class="dashboard">
    <div class="grid-container grid-padding-y">
      <load-overlay bg="white-bg" :show="$root.loading"></load-overlay>
      <router-view></router-view>
    </div>
  </div>
@endsection

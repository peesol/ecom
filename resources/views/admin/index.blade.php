@extends('admin._admin_layout')
@section('content')
  <div class="mobile-menu">
    <button class="fas fa-angle-left" @click.prevent="$router.go(-1)">&nbsp;ย้อนกลับ</button>
    <button class="fas fa-bars" @click.prevent="$root.menu = !$root.menu"></button>
  </div>
  <transition name="width">
    <div class="menu" :class="{'active' : $root.menu}">
      <p class="menu-title hide-for-small-only">Admin</p>
      <router-link class="fas fa-home" to="/admin" @click.prevent="$root.menu = false" exact>หน้าแรก</router-link>
      <a class="fas fa-warehouse" href="{{ url('/admin/product') }}">จัดการสินค้า</a>
      <router-link class="fas fa-grip-horizontal" to="/admin/showcase" @click.native="$root.menu = false">ตู้แสดงสินค้า</router-link>
      <router-link class="fas fa-ad" to="/admin/banner" @click.native="$root.menu = false">แบนเนอร์</router-link>
      <router-link class="fas fa-money-check" to="/admin/payment" @click.native="$root.menu = false">ช่องทางชำระเงิน</router-link>
      <router-link class="fas fa-truck" to="/admin/shipping" @click.native="$root.menu = false">การจัดส่ง</router-link>
      <router-link class="fas fa-list-ul" to="/admin/orders" @click.native="$root.menu = false">รายการสั่งซื้อ</router-link>
      <router-link class="fas fa-user-tie" to="/admin/contact" @click.native="$root.menu = false">ข้อมูลของร้าน</router-link>
      <a class="fas fa-door-open" href="/" @click.native="$root.menu = false">กลับหน้าเว็บไซต์</a>
    </div>
  </transition>
  <div class="dashboard">
    <div class="grid-container grid-padding-y">
      <load-overlay bg="white-bg" :show="$root.loading"></load-overlay>
      <router-view></router-view>
    </div>
  </div>
@endsection

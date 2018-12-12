<template>
<div>
  <button class="fas fa-home icon-nav" type="button"></button>
  <button class="fas fa-shopping-basket icon-nav" type="button"></button>
  <cart-icon></cart-icon>
  <button class="fas fa-user icon-nav" type="button" @click="dropdown = !dropdown"></button>
  <transition name="fade">
    <div class="dropdown-menu right" v-show="dropdown">
      <a><i class="fas fa-user"></i>&nbsp;MY ACCOUNT</a>
      <a><i class="fas fa-list"></i>&nbsp;MY ORDERS</a>
      <a><i class="fas fa-sign-out-alt"></i>&nbsp;LOGOUT</a>
    </div>
  </transition>
</div>
</template>

<script>
import CartIcon from '../cart/CartIcon'
export default {
  components: { CartIcon },
  data() {
    return {
      dropdown: false
    }
  }
}
</script>

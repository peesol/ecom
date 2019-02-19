<template>
<div>
  <button class="fas fa-bars icon-nav" type="button" @click="dropdown = !dropdown"></button>
  <transition name="fade">
    <div class="dropdown-menu left" v-show="dropdown">
      <a><i class="fas fa-user"></i>&nbsp;MY ACCOUNT</a>
      <a><i class="fas fa-list"></i>&nbsp;MY ORDERS</a>
      <a><i class="fas fa-unlock"></i>&nbsp;LOGOUT</a>
    </div>
  </transition>

</div>
</template>

<script>
export default {
  data() {
    return {
      dropdown: false
    }
  }
}
</script>

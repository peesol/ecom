<template>
  <button class="fas fa-shopping-cart icon-nav" @click="goToCart()">
    <span class="cart-count" v-show="count > 0">{{count}}</span>
  </button>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  data() {
    return {

    }
  },
  computed: {
    ...mapGetters([
      'count',
    ]),
  },
  methods: {
    goToCart() {
      document.location.href = this.$root.url + '/cart';
    },
    ...mapActions([
      'getCartCount',
    ]),
  },
  created() {
    this.getCartCount()
  }
}
</script>

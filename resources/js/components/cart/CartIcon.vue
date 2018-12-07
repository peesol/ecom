<template>
<div class="cart">
  <button class="fas fa-shopping-cart" @click="goToCart()">{{count}}</button>
</div>
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

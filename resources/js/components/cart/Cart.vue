<template>
<div class="cart">
  <div class="product" v-for="item in cartContent" v-show="cartContent.length">
    <div class="thumbnail">
      <img :src="imgUrl + item.options.thumbnail" alt="img">
    </div>
    <div class="details">
      <div class="name">{{ item.name }}</div>
      <div class="choice">{{ item.options.choice.name }}</div>
      <div class="price">{{ $number.currency(item.price) }}&nbsp;THB</div>
      <div class="qty">
        <button class="fas fa-minus" type="button" @click="addQty(1, item)"></button>
        <input :min="1" type="number" name="qty" v-model="item.qty" @input.prevent="changeQty(item)">
        <button class="fas fa-plus" type="button" @click="addQty(2, item)"></button>
      </div>
      <div class="actions">
        <button class="fas fa-trash-alt" @click="remove(item.rowId)"></button>
      </div>
    </div>
  </div>
  <div class="text-center" v-show="!cartContent.length">
    <h2>Your cart is empty.</h2>
  </div>
</div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  data() {
    return {
      imgUrl: this.$root.url + '/file/product/thumbnail/',
    }
  },
  computed: {
    ...mapGetters([
      'cartContent'
    ])
  },
  methods: {
    ...mapActions([
      'removeFromCart'
    ]),

    changeQty: _.debounce(function(item) {
      axios.put(this.$root.url + '/cart/update/qty', {rowId: item.rowId, qty: item.qty})
    }, 1600),

    addQty(type, item) {
      var self = this;
			if (type === 1) {
				if (item.qty > 1) {
					item.qty = --item.qty;
          this.changeQty(item)
				}
			} else {
				item.qty = ++item.qty;
        this.changeQty(item)
			}
		},

    remove(rowId, index) {
      if (confirm('ลบสินค้าออกจากรถเข็น?')) {
        this.removeFromCart({rowId, index})
      }
    }
  }
}
</script>

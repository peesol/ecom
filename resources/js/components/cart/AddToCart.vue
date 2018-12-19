<template>
  <form @submit.prevent="add()" class="add-to-cart padding-15-v">
    <div class="form-group padding-15-bottom" v-show="product.choice">
      <label class="full">Options</label>
      <div class="flex column-mobile padding-5-v">
        <div class="radio-input" v-for="(choice, index) in product.choice">
          <input :id="index" type="radio" name="choice" :value="choice.name" v-model="selectedChoice">
          <label :for="index">{{ choice.name }}</label>
          <div class="check"></div>
        </div>
      </div>
    </div>
    <div class="col-2-flex-res">
      <div class="margin-15-bottom-mobile padding-10-right-screen">
        <button class="btn full-width" type="button" @click.prevent="buyNow">Buy now</button>
      </div>
      <div class="padding-10-left-screen">
        <button class="btn full-width" type="submit">Add to cart</button>
      </div>
    </div>
  </form>
</template>

<script>
import { mapActions } from 'vuex'
export default {
  data() {
    return {
      product: this.productData,
      selectedChoice: null,
    }
  },

  props: ['productData'],

  methods: {
    ...mapActions([
      'addToCart',
    ]),
    add() {
      if (this.product.choice) {
        if (this.selectedChoice) {
          if (this.$root.authenticated) {
            this.addToCart({
              product: this.product,
              choice: this.selectedChoice.name,
            });
            toastr.success('เพิ่มลงในตระกร้าแล้ว');
          } else {
            this.$root.showModal = true
          }
        } else {
          alert('โปรดเลือกตัวเลือกสินค้า')
        }
      } else {
        if (this.$root.authenticated) {
          this.addToCart({
            product: this.product,
            choice: this.selectedChoice,
          });
          toastr.success('เพิ่มลงในตระกร้าแล้ว');
        } else {
          this.$root.showModal = true
        }
      }
    },
    buyNow() {
      if (this.product.choice) {
        if (this.selectedChoice) {
          if (this.$root.authenticated) {
            document.location.href = this.$root.url + '/product/' + this.product.uid + '/' + this.selectedChoice + '/buy'
          } else {
            this.$root.showModal = true
          }
        } else {
          alert('โปรดเลือกตัวเลือกสินค้า')
        }
      } else {
        if (this.$root.authenticated) {
          document.location.href = this.$root.url + '/product/' + this.product.uid + '/empty/buy'
        } else {
          this.$root.showModal = true
        }
      }
    }
  }
}
</script>

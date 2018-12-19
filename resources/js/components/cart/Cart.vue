<template>
<div class="cart">
  <div class="product" v-for="item in cartItems" v-show="cartItems.length">
    <div class="thumbnail">
      <img :src="imgUrl + item.options.thumbnail" alt="img">
    </div>
    <div class="details">
      <div class="name">{{ item.name }}</div>
      <div class="choice">{{ item.options.choice ? item.options.choice : '' }}</div>
      <div class="price">{{ $number.currency(item.price) }}&nbsp;THB</div>
      <div class="qty">
        <button class="fas fa-minus" type="button" @click="addQty(1, item)"></button>
        <input :min="1" type="number" name="qty" v-model="item.qty" @input.prevent="changeQty(item)">
        <button class="fas fa-plus" type="button" @click="addQty(2, item)"></button>
      </div>
      <div class="actions" v-show="view == 'cart'">
        <button class="fas fa-trash-alt" @click="remove(item.rowId)"></button>
      </div>
    </div>
  </div>
  <section class="grey col-2-flex-res">
    <div class="padding-10">
      <div class="flex column" v-show="shippings.length">
        <label class="full">Shipping</label>
        <div class="radio-input margin-5-bottom" v-for="(shipping, index) in shippings">
          <input :id="index" type="radio" name="choice" :value="shipping" v-model="confirm.shipping">
          <label :for="index" class="text-nowrap">{{ shipping.method }}&nbsp;{{ shipping.fee ? shipping.fee + ' THB' : 'FREE' }}</label>
          <div class="check"></div>
          <small v-show="shipping.multiply">+{{ shipping.multiply }}&nbsp;THB each if you buy more than 2 items.</small>
          <small v-show="shipping.promotion.type">free shipping if you buy {{ shipping.promotion.amount }}&nbsp;{{ shipping.promotion.type == 'qty' ? 'items' : 'THB' }}</small>
        </div>
      </div>
      <div>
        <h2 class="padding-10-top" v-show="!discountCalc">{{ $number.currency(priceCalc) }}&nbsp;THB</h2>
        <h2 class="padding-10-top font-green" v-show="discountCalc">{{ $number.currency(discountCalc) }}&nbsp;THB</h2>
        <h4 v-show="confirm.fee">Shipping fee: {{ confirm.fee }}&nbsp;THB</h4>
        <h4 v-show="confirm.promotion">Promotion</h4>
        <p class="font-green" v-show="Object.keys(discount).length">Discount&nbsp;-&nbsp;{{ discount.value }}{{ discount.type == 'percent' ? '%' : ' THB'}}</p>
        <div class="flex padding-15-v">
          <label class="padding-10-right" style="line-height:35px">CODE</label>
          <input class="half-width-res" type="text" v-model="code" placeholder="CODE">
          <button class="btn margin-10-left" type="button" name="button" style="height:35px;line-height:1" @click.prevent="redeemCode()">Redeem</button>
        </div>
      </div>
    </div>

    <transition name="fade">
    <div class="padding-10" v-show="confirm.shipping">
      <h2 class="padding-10-bottom">Delivery address</h2>
      <form @submit.prevent="confirmOrder()" method="post">
        <div class="col-2-flex-res">
          <div class="form-group">
            <label class="full">Name</label>
            <input required class="full-width" type="text" v-model="user.name">
          </div>
          <div class="form-group">
            <label class="full">Phone</label>
            <input required class="full-width" type="text" v-model="user.phone">
          </div>
        </div>
        <div class="form-group">
          <label class="full">Address</label>
          <textarea required class="address-input" rows="8" cols="50" v-model="user.address"></textarea>
        </div>
        <div class="text-right">
          <button class="btn half-width-res" type="submit">Confirm</button>
        </div>
      </form>
    </div>
  </transition>
  </section>

  <div class="text-center" v-show="!cartItems.length">
    <h2>Your cart is empty.</h2>
  </div>
</div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  data() {
    return {
      cartItems: [],
      imgUrl: this.$root.url + '/file/product/thumbnail/',
      code: null,
      user: this.userData,
      confirm: {
        shipping: null,
        fee: null,
        promotion: null
      },
      discount: {}
    }
  },
  props: ['userData', 'shippings', 'view', 'productProp'],
  computed: {
    ...mapGetters([
      'cartContent'
    ]),
    priceCalc: function() {
      let totalPrice = [];
      let totalQty = [];
      Object.entries(this.cartItems).forEach(([key, val]) => {
          var subTotal = val.price * val.qty
          totalPrice.push(subTotal)
          totalQty.push(val.qty)
      });
      var total = totalPrice.reduce(function(total, num){ return total + num }, 0);
      var qty = totalQty.reduce(function(total, num){ return total + num }, 0);
      if (this.confirm.shipping) {
        // If shipping is not free
        if (this.confirm.shipping.fee) {
          var includeFee = total + this.confirm.shipping.fee
          if (this.confirm.shipping.multiply) {
            //multiply
            var multiplied = (this.confirm.shipping.multiply * (qty - 1)) + includeFee
            if (this.confirm.shipping.promotion.type) {
              // multiply and promotion
              if (this.confirm.shipping.promotion.type == 'qty') {
                // multiply and QTY promo
                // check if qty is more than promotion amount
                if (qty >= this.confirm.shipping.promotion.amount) {
                  this.confirm.fee = 'FREE'
                  return multiplied - this.confirm.shipping.fee
                } else {
                  this.confirm.fee = this.confirm.shipping.fee
                  return multiplied
                }
              } else {
                // multiply and COST promo
                // check if total cost is more than promotion amount
                if (total > this.confirm.shipping.promotion.amount) {
                  this.confirm.fee = 'FREE'
                  return multiplied - this.confirm.shipping.fee
                } else {
                  this.confirm.fee = this.confirm.shipping.fee
                  return multiplied
                }
              }
            } else {
              // if multiply bot no promo
              return multiplied
            }
          } else {
            // if not multiply
            if (this.confirm.shipping.promotion.type) {
              //not multiply but has promotion
              if (this.confirm.shipping.promotion.type == 'qty') {
                // NO multiply BUT QTY promo
                // check if qty is more than promotion amount
                if (qty >= this.confirm.shipping.promotion.amount) {
                  this.confirm.fee = 'FREE'
                  return includeFee - this.confirm.shipping.fee
                } else {
                  this.confirm.fee = this.confirm.shipping.fee
                  return includeFee
                }
              } else {
                // NO multiply BUT COST promo
                // check if COST is more than promotion amount
                if (total > this.confirm.shipping.promotion.amount) {
                  this.confirm.fee = 'FREE'
                  return includeFee - this.confirm.shipping.fee
                } else {
                  this.confirm.fee = this.confirm.shipping.fee
                  return includeFee
                }
              }
            } else {
              //not multiply no promotion
              return includeFee
            }
          }
        } else {
          // If shipping is free
          return total
        }
      } else {
        // not select shipping yet
        return total
      }
    },

    discountCalc: function () {
      if (this.discount.type == 'percent') {
        var val = (this.discount.value / 100) * this.priceCalc
        return this.priceCalc - val
      } else {
        return this.priceCalc -  this.discount.value
      }
    }
  },
  methods: {
    ...mapActions([
      'removeFromCart'
    ]),

    changeQty: _.debounce(function(item) {
      axios.put(this.$root.url + '/cart/update/qty', {rowId: item.rowId, qty: item.qty}).then(response => {
      })
    }, 1500),

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
    },

    redeemCode() {
      axios.get(this.$root.url + '/api/get/redeem/' + this.code).then(response => {
        this.discount = response.data
        this.code = null
        toastr.success('Discount applied.')
      }, response => {
        alert('Code is not valid.')
      })
    },

    confirmOrder() {
      if (confirm('Confirm?')) {
        axios.post(this.$root.url + '/cart/confirm', {
          name: this.user.name,
          address: this.user.address,
          phone: this.user.phone,
          body: this.cartItems,
          total: this.priceCalc,
          discount: this.discountCalc,
          shipping: this.confirm.shipping,
        }).then(response => {
          document.location.href = this.$root.url + '/order/' + response.data
        })
      }
    }
  },
  created() {
    if (this.view == 'cart') {
      this.cartItems = this.cartContent
    } else {
      this.cartItems = this.productProp
    }
  }
}
</script>

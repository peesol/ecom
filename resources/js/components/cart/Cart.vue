<template>
<div class="cart">
  <table class="unstriped stack hover">
    <tbody>
      <tr v-for="item in cartContent">
        <td>
          <div class="grid-x grid-margin-x">
            <div class="cell medium-2 small-3 shrink">
              <img style="width:100%" :src="imgUrl + item.thumbnail" :alt="item.thumbnail">
            </div>
            <div class="cell small-9 medium-10">
              <p class="">{{ item.name }}</p>
              <p class="">{{ item.options.choice ? item.options.choice : '' }}</p>
            </div>
          </div>
        </td>
        <td><font class="show-for-small-only">ราคา&nbsp;</font>{{ $number.currency(item.price) }}&nbsp;฿</td>
        <td>
          <div class="grid-x">
            <font class="align-self-middle cell show-for-small-only shrink">จำนวน&nbsp;</font>
            <button class="btn-flat primary cell shrink padding-10-h fas fa-minus" type="button" @click="addQty(1, item)"></button>
            <input class="cell small-2 medium-3 no-margin text-center" :min="1" type="number" name="qty" v-model="item.qty" @input.prevent="changeQty(item)">
            <button class="btn-flat primary cell shrink padding-10-h fas fa-plus" type="button" @click="addQty(2, item)"></button>
          </div>
        </td>
        <td class="font-large text-right"><button class="btn-flat error fas fa-trash-alt" @click="remove(item.rowId)"></button></td>
      </tr>
      <!-- <tr>
        <td colspan="4">
          <p class="h4 no-margin">รวม&nbsp;{{ $number.currency(priceCalc) }}&nbsp;THB</p>
        </td>
      </tr> -->
    </tbody>
  </table>

  <section class="grid-x medium-up-2" v-show="cartContent.length">
    <div class="cell">
      <div v-show="shippings.length">
        <label class="lead">เลือกการจัดส่ง</label>
        <div class="grid-x" v-for="(shipping, index) in shippings">
          <input style="margin-top:6px" :id="index" type="radio" name="choice" :value="shipping" v-model="confirm.shipping">
          <label :for="index" class="text-nowrap">
            {{ shipping.method }}&nbsp;{{ shipping.fee ? shipping.fee + ' THB' : 'FREE' }}
            <br v-show="shipping.multiply || shipping.promotion.type">
            <small class="subheader" v-show="shipping.multiply">+{{ shipping.multiply }}&nbsp;THB ต่อชิ้นหากซื้อเกิน 2 ชิ้นขึ้นไป.</small>
            <br v-show="shipping.promotion.type">
            <small class="subheader" v-show="shipping.promotion.type">ส่งฟรีเมื่อซื้อเกิน {{ shipping.promotion.amount }}&nbsp;{{ shipping.promotion.type == 'qty' ? 'ชิ้น' : 'บาท' }}</small>
          </label>
        </div>
      </div>
      <div>
        <h2 class="padding-10-top" v-show="!discountCalc">ยอดชำระ&nbsp;{{ $number.currency(priceCalc) }}&nbsp;THB</h2>
        <h2 class="padding-10-top font-green" v-show="discountCalc">ยอดชำระ&nbsp;{{ $number.currency(discountCalc) }}&nbsp;THB</h2>
        <h4 v-show="confirm.fee">ค่าส่งสินค้า: {{ confirm.fee == 'FREE' ? 'FREE' : confirm.fee + ' THB' }}</h4>
        <h4 v-show="confirm.promotion">Promotion</h4>
        <p class="font-green" v-show="Object.keys(discount).length">Discount&nbsp;-&nbsp;{{ discount.value }}{{ discount.type == 'percent' ? '%' : ' THB'}}</p>
        <div class="grid-x padding-15-bottom form-group">
          <label class="cell small-12">CODE</label>
          <input class="cell no-margin small-8 medium-6" type="text" v-model="code" placeholder="CODE">
          <button class="cell btn primary small-4 medium-3" type="button" name="button" @click.prevent="redeemCode()">ยืนยัน</button>
        </div>
      </div>
    </div>

    <transition name="fade">
    <div class="padding-15-bottom" v-show="confirm.shipping">
      <p class="lead no-margin">ที่อยู่ในการจัดส่ง</p>
      <form @submit.prevent="confirmOrder()" method="post">
        <div class="grid-x medium-up-2 grid-margin-x">
          <div class="cell form-group">
            <label class="full">Name</label>
            <input required class="full-width" type="text" v-model="user.name">
          </div>
          <div class="cell form-group">
            <label class="full">Phone</label>
            <input required class="full-width" type="text" v-model="user.phone">
          </div>
        </div>
        <div class="form-group">
          <label class="full">Address</label>
          <textarea required class="address-input" rows="8" cols="50" v-model="user.address"></textarea>
        </div>
        <div class="grid-x align-right">
          <button class="btn success cell medium-3" type="submit">ยืนยัน</button>
        </div>
      </form>
    </div>
  </transition>
  </section>

  <div class="text-center" v-show="!cartContent.length">
    <h2>ไม่มีสินค้าบนรถเข็น</h2>
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
      Object.entries(this.cartContent).forEach(([key, val]) => {
          var subTotal = val.price * val.qty
          totalPrice.push(subTotal)
          totalQty.push(val.qty)
      });

      var total = totalPrice.reduce(function(total, num){ return total + num }, 0);
      var qty = totalQty.reduce(function(total, num){ return total + num }, 0);
      if (this.confirm.shipping) {
        // If shipping is not free
        if (this.confirm.shipping.fee) {
          this.confirm.fee = this.confirm.shipping.fee
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
                  this.confirm.fee = this.confirm.shipping.fee + (this.confirm.shipping.multiply * (qty - 1))
                  return multiplied
                }
              } else {
                // multiply and COST promo
                // check if total cost is more than promotion amount
                if (total > this.confirm.shipping.promotion.amount) {
                  this.confirm.fee = 'FREE'
                  return multiplied - this.confirm.shipping.fee
                } else {
                  this.confirm.fee = this.confirm.shipping.fee + (this.confirm.shipping.multiply * (qty - 1))
                  return multiplied
                }
              }
            } else {
              // if multiply bot no promo
              this.confirm.fee = this.confirm.shipping.fee + (this.confirm.shipping.multiply * (qty - 1))
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
                  return includeFee
                }
              } else {
                // NO multiply BUT COST promo
                // check if COST is more than promotion amount
                if (total > this.confirm.shipping.promotion.amount) {
                  this.confirm.fee = 'FREE'
                  return includeFee - this.confirm.shipping.fee
                } else {
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
          this.confirm.fee = 'FREE'
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
        toastr.success('ใช้ส่วนลดแล้ว')
      }, response => {
        alert('ไม่สามารถส่วนลดได้ อาจกรอกข้อมูลไม่ถูกต้องหรือส่วนลดถูกใช้ไปหมดแล้ว')
      })
    },

    confirmOrder() {
      if (confirm('ยืนยันการสั่งซื้อ?')) {
        axios.post(this.$root.url + '/cart/confirm', {
          name: this.user.name,
          address: this.user.address,
          phone: this.user.phone,
          body: this.cartContent,
          total: this.priceCalc,
          discount: this.discountCalc,
          shipping: this.confirm.shipping,
          fee: this.confirm.fee,
        }).then(response => {
          document.location.href = this.$root.url + '/order/' + response.data
        })
      }
    },

    setCart() {
      if (this.view == 'cart') {
        console.log('it s a cartt');
        this.cartItems = this.cartContent
      } else {
        this.cartItems = this.productProp
      }
    }
  },
  created() {
    this.setCart()
  }
}
</script>

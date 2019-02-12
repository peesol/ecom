<template>
<div>
  <h2 class="page-title">
    ลดราคาสินค้า
    <back></back>
  </h2>
  <h3>สินค้าลดราคา</h3>
  <div class="thumbnail-row" v-show="discount_products.length">
      <div class="card product" v-for="(item, index) in discount_products">
        <div class="card-section">
          <img :src="$root.url + '/file/product/thumbnail/' + item.thumbnail" alt="img">
        </div>
        <div class="card-section details">
          <p class="title">{{ item.name }}</p>
          <p class="price">
            <s>{{$number.currency(item.price)}}&nbsp;฿</s>&nbsp;
            <font class="font-green">{{$number.currency(item.discount_price)}}&nbsp;฿</font>
          </p>
          <div class="action-wrapper">
            <button @click.prevent="remove(item.uid, index)" class="btn-flat error">เลิกโปรโมชั่น</button>
          </div>
        </div>
      </div>
  </div>

  <h3>สินค้าภายในร้าน</h3>
  <search-filter :can-toggle-view="false" :include-discount="false" v-on:search="addQueryParam"></search-filter>
  <div class="margin-15-bottom" v-show="products.length"></div>
  <div class="thumbnail-row" v-show="products.length">
      <div class="card product" v-for="(item, index) in products">
        <div class="card-section">
          <img :src="$root.url + '/file/product/thumbnail/' + item.thumbnail" alt="img">
        </div>
        <div class="card-section details">
          <p class="title">{{ item.name }}</p>
          <p class="price">{{ $number.currency(item.price) }}&nbsp;฿</p>
          <div class="action-wrapper">
            <button @click.prevent="open(item, index)" class="btn-flat primary">จัดโปรโมชั่น</button>
          </div>
        </div>
      </div>
  </div>

  <modal>
    <form slot="body" @submit.prevent="apply(data.uid, index)">

      <div class="grid-container padding-15-bottom">
        <p class="lead padding-15-top">สินค้า&nbsp;:&nbsp;{{ data.name }}</p>
        <p class="text-center">ราคา&nbsp;:{{ $number.currency(data.price) }}&nbsp;฿
          <font class="font-green" v-show="discount">&nbsp;<i class="fas fa-caret-right"></i>&nbsp;{{ discounted(data.price) }}</font>
        </p>
        <div class="grid-padding-x grid-x align-center-middle padding-15-bottom">
          <span class="cell auto shrink">ส่วนลด</span>
          <input class="cell small-4 no-margin" required type="number" v-model="discount" placeholder="ส่วนลด" min="1" :max="data.price - 1">
          <span class="cell auto shrink">บาท</span>
        </div>
      </div>
      <div class="modal-btn half">
        <button :disabled="$root.loading" :class="{'green' : discount}" type="submit">ยืนยัน</button>
        <button @click.prevent="hide()">ปิด</button>
      </div>
    </form>
  </modal>
</div>
</template>

<script>
import SearchFilter from '../product/partial/Filter'
export default {
  components: {
    SearchFilter
  },
  data() {
    return {
      discount_products: [],
      products: [],
      discount: null,
      formVisible: null,
      remaining_points: this.points,
      data: [],
      index: null,
      query: {
        name: null,
        category: null,
        subcategory: null,
        maxPrice: null,
        minPrice: null,
        discount: null,
        page: null,
      },
    }
  },
  props: {
    points: null,
  },
  methods: {
    addQueryParam(params) {
      _.mapValues(this.query, (val) => {val = null})
      this.query.name = params.name
      this.query.orderBy = params.order
      this.query.category = params.category
      this.query.subcategory = params.subcategory
      this.query.maxPrice = params.max
      this.query.minPrice = params.min
      this.query.discount = params.discount ? true : null
      this.query.page = null
    },
    discounted(price) {
      return this.$number.currency(price - this.discount);
    },
    open(product, index) {
      this.$root.showModal = true
      this.data = product
      this.index = index
    },
    hide() {
      this.$root.showModal = false
      this.data = []
      this.index = null
      this.discount = null
    },
    toggleForm(id) {
      if (this.formVisible === id){
        this.formVisible = null;
        return;
      }
      this.formVisible = id;
    },
    getProduct() {
      this.$root.loading = true
      this.products = []
      axios.get(this.$root.url + '/api/get/products_dc', {
        params: {
          name: this.query.name,
          c: this.query.category,
          sub: this.query.subcategory,
          max: this.query.maxPrice,
          min: this.query.minPrice,
          dc: this.query.discount
        }
      }).then(response => {
        this.products = response.data.products
        this.discount_products = response.data.discount
        this.$root.loading = false
      }, response => {
        this.$root.loading = false
        toastr.error('เกิดข้อผิดพลาด')
      })
    },
    apply(uid, index) {
      this.$root.loading = true
      axios.put(this.$root.url + '/admin/promotions/discount/' + uid + '/apply', {discount:this.discount}).then(response => {
        this.hide()
        this.$root.loading = false
        toastr.success('จัดโปรโมชั่นแล้ว');
        this.$delete(this.products, index);
        this.remaining_points--
        this.discount_products.push(response.data);
        this.discount = null;
        this.formVisible = null;
      }, response => {
        this.$root.loading = false
        this.formVisible = null
        toastr.error('เกิดข้อผิดพลาด')
      });
    },
    remove(uid, index) {
      if (!confirm('คุณแน่ใจหรือไม่ที่จะเลิกโปรโมชั่น?')) {
        return
      } else {
        axios.put(this.$root.url + '/admin/promotions/discount/' + uid + '/cancle').then(response => {
          toastr.success('เลิกโปรโมชั่นแล้ว')
          this.products.unshift(this.discount_products[index]);
          this.discount_products.splice(index, 1);
        }, response => {
          toastr.error('เกิดข้อผิดพลาด')
        });
      }
    }
  },
  created() {
    this.getProduct()
  }
}
</script>

<template>
<div class="padding-15-horizontal">
  <div class="padding-30-bottom" v-show="discount_products.length">
    <h2>สินค้าลดราคา</h2>
    <div class="padding-15-v thumbnail-row" v-show="products.length">
      <div class="thumbnail-wrapper" v-for="(item, index) in discount_products">
        <div class="thumbnail-img-wrapper">
          <img :src="$root.url + '/file/product/thumbnail/' + item.thumbnail" alt="img">
        </div>
        <div class="details">
          <p class="title">{{ item.name }}</p>
          <p class="price">
            <s>{{$number.currency(item.price)}}&nbsp;฿</s>&nbsp;
            <font class="font-green">{{$number.currency(item.discount_price)}}&nbsp;฿</font>
          </p>
          <div class="text-left padding-5-top">
            <button @click.prevent="remove(item.uid, index)" class="btn red">เลิกโปรโมชั่น</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <h2>สินค้าภายในร้าน</h2>
  <search-filter :can-toggle-view="false" :include-discount="false" v-on:search="addQueryParam"></search-filter>
  <div class="padding-15-v thumbnail-row" v-show="products.length">
    <div class="thumbnail-wrapper" v-for="(item, index) in products">
      <div class="thumbnail-img-wrapper">
        <img :src="$root.url + '/file/product/thumbnail/' + item.thumbnail" alt="img">
      </div>
      <div class="details">
        <p class="title">{{ item.name }}</p>
        <p class="price">{{ $number.currency(item.price) }}&nbsp;฿</p>
        <div class="text-left padding-5-top">
          <button @click.prevent="open(item, index)" class="btn teal">จัดโปรโมชั่น</button>
        </div>
      </div>
    </div>
  </div>

  <modal>
    <form slot="body" @submit.prevent="apply(data.uid, index)">
      <p class="padding-15-h">สินค้า&nbsp;:&nbsp;{{ data.name }}</p>
      <div class="padding-15-h padding-15-bottom text-center">
        <p>ราคา&nbsp;:{{ $number.currency(data.price) }}&nbsp;฿
          <font class="font-green" v-show="discount">&nbsp;<i class="fas fa-caret-right"></i>&nbsp;{{ discounted(data.price) }}</font>
        </p>
        <span>ส่วนลด</span>
        <input required type="number" v-model="discount" placeholder="ส่วนลด" min="1" :max="data.price - 1">
        <span>บาท</span>
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
      this.query.category = params.category
      this.query.subcategory = params.subcategory
      this.query.maxPrice = params.max
      this.query.minPrice = params.min
      this.query.discount = params.discount
      this.query.page = null
      this.getProduct()
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

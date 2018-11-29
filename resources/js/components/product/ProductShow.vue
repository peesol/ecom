<template lang="html">
<div>
  <p>สินค้า&nbsp;{{ meta.total }}&nbsp;รายการ&nbsp;({{ meta.last_page }}&nbsp;หน้า)</p>
  <search-filter v-on:search="addQueryParam" v-on:changeView="changeView"></search-filter>
  <pagination :meta="meta" v-on:switched="changePage" v-show="products.length"></pagination>
  <div class="padding-15-v" :class="{'thumbnail-grid' : view == 'grid', 'thumbnail-row' : view == 'list'}" v-if="products.length">
    <div class="thumbnail-wrapper" :class="{'product' : $root.role == 'guest', 'admin-product' : $root.role == 'admin'}" v-for="item in products">
      <div class="thumbnail-img-wrapper">
        <img :src="imgUrl + item.thumbnail" :alt="item.thumbnail">
      </div>
      <div class="details">
        <p class="title">{{ item.name }}</p>
        <p class="price">{{ $number.currency(item.price) }}&nbsp;บาท</p>
        <p class="category">{{ item.category.name }}&nbsp;/&nbsp;{{ item.subcategory.name }}</p>
        <div :class="{'text-right' : view == 'grid', 'text-left' : view == 'list'}" v-show="$root.role == 'admin'">
          <a :href="$root.url + '/admin/product/edit/' + item.uid" class="btn-flat blue margin-10-right" type="button">แก้ไข</a>
          <a @click.prevent="remove(index, item.uid)" class="btn-flat red margin-10-right" type="button">ลบ</a>
        </div>
      </div>
    </div>
  </div>
  <div class="text-center padding-10-v" v-else>
    <h1>ไม่มีสินค้า</h1>
  </div>
  <pagination :meta="meta" v-on:switched="changePage" v-show="products.length"></pagination>
</div>
</template>
<script>
import SearchFilter from './partial/Filter'
import Pagination from './partial/Pagination'
export default {
  components: {
    SearchFilter,
    Pagination
  },
  data() {
    return {
      products: [],
      meta: [],
      imgUrl: this.$root.url + '/file/product/thumbnail/',
      query: {
        name: null,
        category: null,
        subcategory: null,
        maxPrice: null,
        minPrice: null,
        discount: null,
        page: null,
      },
      view: 'grid'
    }
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
    changePage(page) {
      this.query.page = page
      this.getProduct()
    },
    changeView(view) {
      this.view = view
    },
    getProduct() {
      this.$root.loading = true
      this.products = []
      axios.get(this.$root.url + '/api/get/products', {
        params: {
          name: this.query.name,
          c: this.query.category,
          sub: this.query.subcategory,
          max: this.query.maxPrice,
          min: this.query.minPrice,
          dc: this.query.discount,
          page: this.query.page ? this.query.page : 1,
        }
      }).then(response => {
        this.products = response.data.data
        this.meta = response.data.meta
        this.$root.loading = false
      }, response => {
        this.$root.loading = false
        toastr.error('เกิดข้อผิดพลาด')
      })
    },
    remove(index, uid) {
      if (confirm('คุณแน่ใจหรือไม่ว่าต้องการจะลบสินค้านี้?')) {
        axios.delete(this.$root.url + '/admin/product/delete/' + uid).then(response => {
          toastr.success('ลบสินค้าแล้ว')
          this.products.splice(index, 1)
        }, response => {
          toastr.error('เกิดข้อผิดพลาด')
        })
      }
    }
  },
  created() {
    this.getProduct()
  }
}
</script>

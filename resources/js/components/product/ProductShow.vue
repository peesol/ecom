<template lang="html">
<div>
  <p>สินค้า&nbsp;{{ meta.total }}&nbsp;รายการ&nbsp;({{ meta.last_page }}&nbsp;หน้า)</p>
  <search-filter :can-toggle-view="true" :include-discount="true" v-on:search="addQueryParam" v-on:changeView="changeView"></search-filter>
  <pagination :meta="meta" v-on:switched="changePage" v-show="products.length"></pagination>
  <div class="padding-15-v" :class="{'thumbnail-grid' : view == 'grid', 'thumbnail-row' : view == 'list'}" v-if="products.length">
    <div class="thumbnail-wrapper" :class="{'product' : $root.role == 'guest', 'admin-product' : $root.role == 'admin'}" v-for="(item, index) in products">
      <div class="thumbnail-img-wrapper">
        <a :href="$root.url + '/product/' + item.uid">
          <img :src="imgUrl + item.thumbnail" :alt="item.thumbnail">
        </a>
        <span class="top-right sale" v-show="item.discount_price">-&nbsp;{{ saleCalc(item.price, item.discount_price) }}%</span>
      </div>
      <div class="details">
        <a class="title" :href="$root.url + '/product/' + item.uid">{{ item.name }}</a>
        <p class="price" v-show="!item.discount_price">{{ $number.currency(item.price) }}&nbsp;บาท</p>
        <p class="price sale" v-show="item.discount_price"><s>{{ $number.currency(item.price) }}</s>&nbsp;{{ $number.currency(item.discount_price) }}&nbsp;บาท</p>
        <p class="category" v-show="$root.role !== 'guest'">{{ item.category.name }}&nbsp;/&nbsp;{{ item.subcategory.name }}</p>
        <div :class="{'text-right' : view == 'grid', 'text-left' : view == 'list'}" v-show="$root.role == 'admin'">
          <a @click.prevent="addToHome(item.uid, index)" class="fas float-left" :class="{'fa-check font-green' : item.featured, 'fa-times font-red' : !item.featured}">&nbsp;หน้าแรก</a>
          <a :href="$root.url + '/admin/product/' + item.uid + '/edit'" class="btn-flat blue margin-10-right" type="button">แก้ไข</a>
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
        orderBy: null,
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
      this.query.orderBy = params.order
      this.query.category = params.category
      this.query.subcategory = params.subcategory
      this.query.maxPrice = params.max
      this.query.minPrice = params.min
      this.query.discount = params.discount ? true : null
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
      axios.get(this.$root.url + '/api/get/products_paginate', {
        params: {
          name: this.query.name,
          order: this.query.orderBy,
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
    },
    saleCalc(price, discount) {
      var val = (price - discount) / ((price + discount) / 2)
      var result = val * 100
      return  Math.round(result);
    },
    addToHome(uid, index) {
      axios.put(this.$root.url + '/admin/product/feature/' + uid).then(response => {
        toastr.success('เพิ่มในหน้าแรกแล้ว')
        this.products[index].featured = true
      }, response => {
        toastr.error('เกิดข้อผิดพลาด')
      })
    }
  },
  created() {
    this.getProduct()
  }
}
</script>

<template>
<div>
  <h2 class="page-title">ตู้แสดงสินค้า
		<back></back>
	</h2>
  <div class="grid-x padding-15-bottom">
    <div class="cell medium-6">
      <label class="lead">ชื่อตู้แสดงสินค้า</label>
      <div class="grid-x">
        <input class="no-margin cell auto" type="text" v-model="name" name="name">
        <button class="btn success medium-3" :disabled="$root.loading" @click.prevent="edit">แก้ไข</button>
      </div>
    </div>
  </div>

  <div class="showcase-product">
    <h3>สินค้าในตู้&nbsp;<span class="number" :class="{'font-green' : showcaseProducts.length >= 1}">{{ showcaseProducts.length }}</span>&nbsp;ชิ้น</h3>
    <div class="thumbnail-row" v-show="showcaseProducts.length">
        <div class="card product" v-for="(item, index) in showcaseProducts">
          <div class="card-section">
            <img :src="$root.url + '/file/product/thumbnail/' + item.thumbnail" alt="img">
          </div>
          <div class="card-section details">
            <p class="title">{{ item.name }}</p>
            <p class="price">{{ $number.currency(item.price) }}&nbsp;฿</p>
            <div class="action-wrapper">
              <button @click.prevent="addToShowcase(item, index, false)" class="btn error">ลบออกจากตู้</button>
            </div>
          </div>
        </div>
    </div>
  </div>

  <div class="shop-product">
    <h3>สินค้าในร้าน&nbsp;<span class="number" :class="{'font-green' : meta.total >= 1}">{{ meta.total }}</span>&nbsp;ชิ้น</h3>
    <search-filter :can-toggle-view="false" :include-discount="true" v-on:search="addQueryParam"></search-filter>
    <pagination :meta="meta" v-on:switched="changePage" v-show="products.length"></pagination>
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
              <button @click.prevent="addToShowcase(item, index, true)" class="btn primary">ใส่ในตู้</button>
            </div>
          </div>
        </div>
    </div>
    <pagination :meta="meta" v-on:switched="changePage" v-show="products.length"></pagination>
  </div>

  <div v-show="!products.length" class="padding-15-vertical align-center">
    <h2 class="font-grey">ไม่มีสินค้า</h2>
  </div>
</div>


</template>

<script>
  import SearchFilter from '../Partials/Filter'
  import Pagination from '../Partials/Pagination'
	export default{
    components: {
      SearchFilter,
      Pagination
    },
		data() {
			return {
        name: null,
        products: [],
        showcaseProducts: [],
        loaded: false,
        meta: null,
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
			}
		},
    methods: {
      getProduct() {
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
        })
      },
      getShowcase() {
        axios.get(this.$root.url + '/api/get/showcase/' + this.$route.params.showcase).then(response => {
          this.showcaseProducts = response.data.products
          this.name = response.data.name
        })
      },
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
      addToShowcase(product, index, add) {
        axios.put(this.$root.url + '/admin/showcase/add_product/' + this.$route.params.showcase, {
          product_id: product.id
        }).then(response => {
          if (add) {
            this.products.splice(index, 1)
            this.showcaseProducts.push(product)
            toastr.success('เพิ่มสินค้าแล้ว')
          } else {
            this.showcaseProducts.splice(index, 1)
            this.products.push(product)
            toastr.success('นำสินค้าออกแล้ว')
          }
        })
      },
      edit() {
        this.$root.loading = true
        axios.put(this.$root.url + '/admin/showcase/update_name/' + this.$route.params.showcase, {
          name: this.name
        }).then(response => {
          toastr.success('บันทึกชื่อใหม่แล้ว')
          this.$root.loading = false
        }, response => {
          toastr.error('เกิดข้อผิดพลาด')
          this.$root.loading = false
        })
      }
    },
    created() {
      this.$root.loading = true
      this.getProduct()
      this.getShowcase()
      this.$root.loading = false
    }
	}
</script>

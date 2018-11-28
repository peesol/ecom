<template lang="html">
<div>
  <search-filter v-on:search="addQueryParam"></search-filter>
  <div class="thumbnail-grid padding-15-v">
    <div class="thumbnail-wrapper product" v-for="item in products">
      <div class="thumbnail-img-wrapper">
        <img :src="imgUrl + item.thumbnail" alt="">
      </div>
      <p class="title">{{ item.name }}</p>
      <p class="price">{{ $number.currency(item.price) }}</p>
      <p class="category"></p>
    </div>
  </div>
</div>
</template>

<script>
import SearchFilter from './partial/Filter'
export default {
  components: {
    SearchFilter
  },
  data() {
    return {
      products: [],
      imgUrl: this.$root.url + '/file/product/thumbnail/',
      query: {
        category: null,
        subcategory: null,
        maxPrice: null,
        minPrice: null,
        discount: null,
      }
    }
  },
  methods: {
    addQueryParam(params) {
      _.mapValues(this.query, (val) => {val = null})
      this.query.category = params.category
      this.query.subcategory = params.subcategory
      this.query.maxPrice = params.max
      this.query.minPrice = params.min
      this.query.discount = params.discount
      //this.getProduct()
    },
    getProduct() {
      this.$root.loading = true
      axios.get(this.$root.url + '/api/get/products', {
        params: {
          c: this.query.category,
          sub: this.query.subcategory,
          max: this.query.maxPrice,
          min: this.query.minPrice,
          dc: this.query.discount,
        }
      }).then(response => {
        this.products = response.data
        this.$root.loading = false
      }, response => {
        this.$root.loading = false
        toastr.error('เกิดข้อผิดพลาด')
      })
    }
  },
  created() {
    this.getProduct()
  }
}
</script>

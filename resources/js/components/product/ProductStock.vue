<template>
<div>
  <h2 class="page-title">สต๊อกสินค้า
    <back></back>
  </h2>
  <div class="padding-10-v">
    <i class="fas fa-circle font-green"></i>&nbsp;มีสินค้า<br>
    <i class="fas fa-circle font-red"></i>&nbsp;สินค้าหมด<br>
    **คลิกที่ชื่อสินค้าเพื่อแก้ไขสต๊อกสินค้า
  </div>
  <search-filter :can-toggle-view="false" :include-discount="false" v-on:search="addQueryParam"></search-filter>
  <div class="clickable-list padding-15-v">
    <div v-for="(item, index) in products" @click.prevent="open(item, index)">
      <p><i class="fas fa-circle" :class="{'font-green' : item.stock >= 1, 'font-red' : item.stock < 1}"></i>&nbsp;{{ item.name }}</p>
      จำนวนสินค้า&nbsp;{{ item.stock }}
    </div>
  </div>

  <modal>
    <form slot="body" @submit.prevent="changeStock(data.uid, data.index)">
      <div class="grid-container padding-15-bottom">
        <p class="lead padding-15-top">สินค้า&nbsp;:&nbsp;{{ data.name }}</p>
        <div class="grid-padding-x grid-x align-center-middle padding-15-bottom">
          <span class="cell auto shrink">จำนวน</span>
          <input class="cell small-4 no-margin" required type="number" v-model="stock" :min="0">
          <span class="cell auto shrink">ชิ้น</span>
        </div>
      </div>
      <div class="modal-btn half">
        <button :disabled="$root.loading" type="submit">ยืนยัน</button>
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
      products: [],
      data: [],
      index: null,
      stock: null,
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
  methods: {
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
          dc: this.query.discount
        }
      }).then(response => {
        this.products = response.data
        this.$root.loading = false
      }, response => {
        this.$root.loading = false
        toastr.error('เกิดข้อผิดพลาด')
      })
    },
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
    changeStock(uid) {
      this.$root.loading = true
      axios.put(this.$root.url + '/admin/product/stock/' + uid ,{
        stock: this.stock
      }).then(response => {
        toastr.success('อัพเดทสต๊อกสินค้าแล้ว')
        this.products[this.index].stock = this.stock
        this.hide()
        this.$root.loading = false
      }, response => {
        toastr.error('เกิดข้อผิดพลาด')
        this.stock = null
        this.$root.loading = false
      })
    },
    open(product, index) {
      this.stock = product.stock
      this.$root.showModal = true
      this.data = product
      this.index = index
    },
    hide() {
      this.stock = null
      this.index = null
      this.$root.showModal = false
      this.data = []
    },
  },
  created() {
    this.getProduct()
  }
}
</script>

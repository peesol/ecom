<template>
<div>
  <div>
    <button class="btn blue" @click.prevent="formVisible = !formVisible">ตัวกรอง&nbsp;<i class="fas fa-filter"></i></button>
  </div>
  <transition name="fade">
  <div v-show="formVisible" class="filter toggle-form margin-15-top half-width-res">
    <div class="category">
      <li v-for="category in categories" @click.prevent="selectCategory(category)" :class="{'active': category.id == selected.c }">{{ category.name }}</li>
    </div>
    <div class="category" v-show="selected.c && subcategories.length">
      <li v-for="subcategory in subcategories" @click.prevent="selectSubcategory(subcategory)" :class="{'active': subcategory.id == selected.sub }">{{ subcategory.name }}</font></li>
    </div>
    <div class="form-group margin-15-top">
      <label class="full">ราคา</label>
      <input type="number" min="0" max="9999999" v-model="min" autocomplete="off" placeholder="ต่ำสุด">&nbsp;-&nbsp;
      <input type="number" min="0" max="9999999" v-model="max" autocomplete="off" placeholder="สูงสุด">
      <div class="flex padding-10-top">
        <label class="margin-10-right">เฉพาะสินค้าลดราคา</label>
        <input class="regular" type="checkbox" name="discount" v-model="selected.discount">
      </div>
    </div>
    <transition name="fade">
    <div class="breadcrumb" v-show="selected.c || min || max || selected.discount">
      <p class="no-margin">คุณกำลังค้นหา</p>
      <div v-show="selected.c">
        <font class="font-bold">หมวดหมู่</font>
        <span>{{ breadcrumb.category }}</span>
        <span>{{ breadcrumb.subcategory }}</span>
      </div>
      <span v-show="min">ราคาต่ำสุด&nbsp;{{ $number.currency(min) }}&nbsp;</span>
      <span v-show="max">ราคาสูงสุด&nbsp;{{ $number.currency(max) }}</span>
      <span class="font-green" v-show="selected.discount">สินค้าลดราคาเท่านั้น</span>
      <div class="text-left-res margin-15-top">
        <button class="btn blue form-submit" type="button" @click="applyFilter()">ค้นหา</button>
      </div>
    </div>
    </transition>
  </div>
</transition>
</div>
</template>

<script>
export default {
    data() {
      return {
        categories : [],
        subcategories: [],
        products : [],
        min : null,
        max : null,
        formVisible: false,
        breadcrumb: {},
        selected: {
          discount: false
        },
      }
    },
    methods: {
      getCategory() {
        this.$root.loading = true
        this.$Progress.start()
        axios.get(this.$root.url + '/api/get/category').then(response => {
          this.categories = response.data
          this.$root.loading = false
          this.$Progress.finish()
        })
      },
      applyFilter() {
        this.$emit('search', {
          category: this.selected.c,
          subcategory: this.selected.sub,
          discount: this.selected.discount,
          min: this.min,
          max: this.max,
        })
      },
      selectCategory(category) {
        this.subcategories = category.subcategory
        this.breadcrumb = Object.assign({}, this.breadcrumb, {
          category: category.name,
          subcategory: null
        })
        this.selected = Object.assign({}, this.selected, {
          c: category.id,
          sub: null
        })
      },
      selectSubcategory(subcategory) {
        this.types = subcategory.type,
        this.breadcrumb = Object.assign({}, this.breadcrumb, {
          subcategory: subcategory.name
        })
        this.selected = Object.assign({}, this.selected, {
          sub: subcategory.id
        })
      }
    },
    created() {
      this.getCategory()
    }
}
</script>

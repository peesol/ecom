<template>
<div>
  <h2 class="page-title">การส่งสินค้า
    <back></back>
  </h2>
  <div class="margin-15-v">
    <button class="btn primary" type="button" @click="formVisible = !formVisible">เพิ่มการช่องทางส่งสินค้า&nbsp;<i class="fas fa-plus"></i></button>
  </div>
  <transition name="fade">
    <div class="grid-x">
      <form class="grid-y cell medium-6 filter" v-show="formVisible" @submit.prevent="create()">
        <div class="form-group">
          <label>ชื่อการจัดส่ง</label>
          <input required type="text" v-model="form.method" placeholder="EMS Kerry อื่นๆ">
        </div>
        <label class="checkbox lead" :class="{'active' : free }">
          ส่งสินค้าฟรี?
          <input type="checkbox" name="free" v-model="free">
        </label>
        <transition name="fade">
          <div class="grid-x form-group padding-10-v grid-margin-x" v-show="!free">
            <label class="cell align-self-middle auto shrink">ค่าส่งสินค้า</label>
            <input :required="!free" class="cell no-margin medium-2 small-4" type="number" v-model="form.fee">
            <label class="cell align-self-middle auto shrink">บาท</label>
          </div>
        </transition>
        <transition name="fade">
          <div class="flex padding-10-v" v-show="!free">
            <label class="checkbox lead" :class="{'active' : multiply }">
              คิดค่าขนส่งต่อชิ้นเมื่อซื้อชิ้นที่สองขึ้นไป?
              <input type="checkbox" name="free" v-model="multiply">
            </label>
          </div>
        </transition>
        <transition name="fade">
          <div class="grid-x form-group padding-10-v grid-margin-x" v-show="multiply && !free">
            <label class="cell align-self-middle auto shrink">ค่าส่งเพิ่ม</label>
            <input :required="multiply && !free" class="cell no-margin medium-2 small-4" type="number" v-model="form.multiply">
            <label class="cell align-self-middle auto shrink">ต่อชิ้น</label>
          </div>
        </transition>
        <transition name="fade">
          <div class="flex padding-10-v" v-show="!free">
            <label class="checkbox lead" :class="{'active' : promotion }">
              ส่งฟรีเมื่อซื้อถึงขั้นต่ำ?
              <input type="checkbox" name="free" v-model="promotion">
            </label>
          </div>
        </transition>
        <transition name="fade">
          <div class="grid-x form-group" v-show="promotion && !free">
            <label class="cell small-12">ส่งฟรีเมื่อซื้อ</label>
            <input class="cell small-6 medium-4" :required="promotion && !free" type="number" v-model="form.promotion.amount" placeholder="จำนวน">
            <select class="cell small-6 medium-4" :required="promotion && !free" v-model="form.promotion.type">
              <option value="qty">ชิ้น</option>
              <option value="cost">บาท</option>
            </select>
          </div>
        </transition>
        <div class="grid-x padding-15-top-mobile align-right">
          <button :disabled="errors.any()" type="submit" class="btn success cell medium-4">ยืนยัน</button>
        </div>
      </form>
    </div>
  </transition>
  <div v-show="shippings.length">
    <h3 class="margin-15-v">ช่องทางจัดส่งของร้าน</h3>
    <table class="stack hover unstriped">
      <tbody>
        <tr v-for="(shipping, index) in shippings">
          <td>
            <div class="list">
              <h4>{{ index + 1 }}.&nbsp;{{ shipping.method }}</h4>
              <li class="dash">ค่าส่ง&nbsp;{{ shipping.fee ? shipping.fee + ' บาท' : 'FREE' }}</li>
              <li class="dash" v-show="shipping.multiply">เพิ่มค่าส่ง&nbsp;{{ shipping.multiply }}&nbsp;บาท/ชิ้น</li>
              <li class="dash" v-show="shipping.promotion.type">ส่งฟรีเมื่อซื้อครบ&nbsp;{{ shipping.promotion.amount }}&nbsp;{{ shipping.promotion.type == 'qty' ? 'ชิ้น' : 'บาท' }}</li>
            </div>
          </td>
          <td class="text-right">
            <button class="btn error fas fa-trash-alt" type="button" @click="remove(shipping.id, index)"></button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="text-center margin-15-v" v-show="!shippings.length">
    <h2>คุณไม่มีช่องทางส่งสินค้า</h2>
  </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      shippings: [],
      form: {
        method: null,
        fee: null,
        multiply: null,
        promotion: {
          amount: null,
          type: null
        }
      },
      free: false,
      multiply: false,
      promotion: false,
      formVisible: false
    }
  },
  watch: {
    free: function () {
      this.form.fee = null
      this.multiply = false
      this.promotion = false
    },
    multiply: function () {
      this.form.multiply = null
    },
    promotion: function () {
      this.form.promotion.amount = null
      this.form.promotion.type = null
    }
  },
  methods: {
    getShipping() {
      this.$root.loading = true
      axios.get(this.$root.url + '/api/get/shipping').then(response => {
        this.shippings = response.data
        this.$root.loading = false
      })
    },
    create() {
      this.$root.loading = true
      axios.post(this.$root.url + '/admin/shipping/add', {
        method: this.form.method,
        fee: this.form.fee,
        multiply: this.form.multiply,
        promotion: this.form.promotion
      }).then(response => {
        this.shippings.push(response.data)
        toastr.success('เพิ่มช่องทางการส่งสินค้าแล้ว')
        this.$root.loading = false
      }, response => {
        toastr.error('เกิดข้อผิดพลาด')
        this.$root.loading = false
      })
    },
    remove(id, index) {
      if(confirm('คุณแน่ใจหรือไม่ว่าจะลบ?')) {
        axios.delete(this.$root.url + '/admin/shipping/delete/' + id).then(response => {
          this.shippings.splice(index, 1)
          toastr.success('ลบเรียบร้อยแล้ว')
        }, response => {
          toastr.error('เกิดข้อผิดพลาด')
        })
      }
    }
  },
  created() {
    this.getShipping()
  }
}
</script>

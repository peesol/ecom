<template>
<div>
  <div class="text-left">
    <button class="btn blue" type="button" @click="formVisible = !formVisible">เพิ่มการช่องทางส่งสินค้า&nbsp;+</button>
  </div>
  <transition name="fade">
    <form class="toggle-form margin-15-top" v-show="formVisible" @submit.prevent="create()">
      <div class="form-group">
        <label class="full">คำอธิบาย เช่น ส่งด่วน EMS</label>
        <input required type="text" v-model="form.method">
      </div>
      <div class="flex padding-10-v">
        <label class="margin-10-right">ส่งสินค้าฟรี่?</label>
        <input class="regular" type="checkbox" name="free" v-model="free">
      </div>
      <transition name="fade">
        <div class="input-group padding-10-v" v-show="!free">
          <label class="">ค่าส่งสินค้า</label>
          <input :required="!free" class="half-width-res" type="number" v-model="form.fee">
          <label class="">บาท</label>
        </div>
      </transition>
      <transition name="fade">
        <div class="flex padding-10-v" v-show="!free">
          <label class="margin-10-right">คิดค่าขนส่งต่อชิ้นเมื่อซื้อชิ้นที่สองขึ้นไป?</label>
          <input class="regular" type="checkbox" name="free" v-model="multiply">
        </div>
      </transition>
      <transition name="fade">
        <div class="input-group padding-10-v" v-show="multiply && !free">
          <label class="">ค่าส่งเพิ่ม</label>
          <input :required="multiply && !free" class="half-width-res" type="number" v-model="form.multiply">
          <label class="">ต่อชิ้น</label>
        </div>
      </transition>
      <transition name="fade">
        <div class="flex padding-10-v" v-show="!free">
          <label class="margin-10-right">ส่งฟรีเมื่อซื้อถึงขั้นต่ำ?</label>
          <input class="regular" type="checkbox" name="free" v-model="promotion">
        </div>
      </transition>
      <transition name="fade">
        <div class="input-group padding-10-v" v-show="promotion && !free">
          <label class="">ส่งฟรีเมื่อซื้อ</label>
          <input :required="promotion && !free" class="half-width-res" type="number" v-model="form.promotion.amount" placeholder="จำนวน">
          <select :required="promotion && !free" class="select-input" v-model="form.promotion.type">
            <option value="qty">ชิ้น</option>
            <option value="cost">บาท</option>
          </select>
        </div>
      </transition>
      <div class="text-right padding-15-top-mobile">
        <button :disabled="errors.any()" type="submit" class="btn blue form-submit">ยืนยัน</button>
      </div>
    </form>
  </transition>
  <div v-show="shippings.length">
    <h2>ช่องทางจัดส่งของร้าน</h2>
    <div class="col-2-flex-res border-bottom-grey padding-10" v-for="(shipping, index) in shippings">
      <div class="list">
        <h4>{{ index + 1 }}.&nbsp;{{ shipping.method }}</h4>
        <li class="dash">ค่าส่ง&nbsp;{{ shipping.fee ? shipping.fee + ' บาท' : 'FREE' }}</li>
        <li class="dash" v-show="shipping.multiply">เพิ่มค่าส่ง&nbsp;{{ shipping.multiply }}&nbsp;บาท/ชิ้น</li>
        <li class="dash" v-show="shipping.promotion.type">ส่งฟรีเมื่อซื้อครบ&nbsp;{{ shipping.promotion.amount }}&nbsp;{{ shipping.promotion.type == 'qty' ? 'ชิ้น' : 'บาท' }}</li>
      </div>
      <div class="text-right">
        <button @click.prevent="remove(shipping.id, index)" class="btn-flat red" type="button">ลบ</button>
      </div>
    </div>
  </div>
  <div class="text-center" v-show="!shippings.length">
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
      axios.get(this.$root.url + '/api/get/shipping').then(response => {
        this.shippings = response.data
      })
    },
    create() {
      axios.post(this.$root.url + '/admin/shipping/add', {
        method: this.form.method,
        fee: this.form.fee,
        multiply: this.form.multiply,
        promotion: this.form.promotion
      }).then(response => {
        this.shippings.push(response.data)
        toastr.success('เพิ่มช่องทางการส่งสินค้าแล้ว')
      }, response => {
        toastr.error('เกิดข้อผิดพลาด')
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

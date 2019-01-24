<template>
<div>
  <h2 class="page-title">
    โค๊ดส่วนลด
    <back></back>
  </h2>
  <form @submit.prevent="create">
    <div class="grid-x">
      <div class="form-group cell medium-4">
        <label class="lead">เพิ่มโค๊ดส่วนลด</label>
        <input required type="text" v-model="form.code" placeholder="CODE">
      </div>
    </div>
    <div class="grid-x">
      <div class="form-group cell medium-4">
        <label class="lead">มูลค่าส่วนลด</label>
        <div class="flex">
          <input required :max="maxValue" type="number" class="no-margin" v-model="form.value" placeholder="ส่วนลด">
          <select required class="select-input no-margin" v-model="form.type">
            <option value="percent">%</option>
            <option value="cash">บาท</option>
          </select>
          <button class="btn success" type="submit">สร้าง</button>
        </div>
      </div>
    </div>
  </form>
  <div class="padding-15-v" v-show="codes.length">
    <h3>ส่วนลดของร้าน</h3>
    <div class="list">
      <li class="no-style table-like" v-for="(code, index) in codes">
        <a class="btn-flat error" @click.prevent="remove(code.id, index)">ลบ</a>&nbsp;
        {{ code.code }}&nbsp;ลด&nbsp;{{ code.value }}{{ code.type == 'cash' ? ' บาท' : '%' }}
      </li>
    </div>
  </div>
  <div class="text-center padding-15-v margin-15-top" v-show="!codes.length">
    <h3>ร้านของคุณไม่มีส่วนลด</h3>
  </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        code: null,
        value: null,
        type: null
      },
      codes: []
    }
  },
  computed: {
    maxValue() {
      if (this.form.type == 'percent') {
        return 99;
      } else {
        return ;
      }
    }
  },
  methods: {
    getCode() {
      this.$root.loading = true
      axios.get(this.$root.url + '/api/get/code').then(response => {
        this.codes = response.data
        this.$root.loading = false
      })
    },
    create() {

      this.$root.loading = true
      axios.post(this.$root.url + '/admin/promotions/code/create', {
        form: this.form
      }).then(response => {
        _.mapValues(this.form, (val) => {val = null})
        this.codes.push(response.data)
        toastr.success('เพิ่มโค๊ดส่วนลดแล้ว')
        this.$root.loading = false
      }, response => {
        toastr.error('เกิดข้อผิดพลาด')
        this.$root.loading = false
      })
    },
    remove(id, index) {
      if (confirm('คุณแน่ใจหรือไม่ว่าจะลบ')) {
        this.$root.loading = true
        axios.delete(this.$root.url + '/admin/promotions/code/delete/' + id).then(response => {
          this.codes.splice(index, 1)
          toastr.success('ลบโค๊ดแล้ว')
          this.$root.loading = false
        }, response => {
          toastr.error('เกิดข้อผิดพลาด')
          this.$root.loading = false
        })
      }
    }
  },
  created() {
    this.getCode()
  }
}
</script>

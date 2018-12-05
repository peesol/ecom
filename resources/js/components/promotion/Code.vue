<template>
<div>
  <form @submit.prevent="create" class="half-width-res form-group toggle-form">
    <label class="full">เพิ่มโค๊ดส่วนลด</label>
    <input required type="text" v-model="form.code" placeholder="CODE">
    <label class="full padding-10-top">มูลค่าส่วนลด</label>
    <div class="full-width flex">
      <input required type="number" class="margin-10-right" v-model="form.value" placeholder="ส่วนลด">
      <select required class="select-input" v-model="form.type">
        <option value="%">%</option>
        <option value="cash">บาท</option>
      </select>
    </div>
    <div class="text-right padding-15-top">
      <button class="btn blue" type="submit">ตกลง</button>
    </div>
  </form>
  <div class="padding-15-v" v-show="codes.length">
    <div class="list">
      <li class="no-style table-like" v-for="(code, index) in codes">
        <a class="delete" @click.prevent="remove(code.id, index)">ลบ</a>&nbsp;
        {{ code.code }}&nbsp;ลด&nbsp;{{ code.value }}{{ code.type == 'cash' ? ' บาท' : '%' }}
      </li>
    </div>
  </div>
  <div class="text-center padding-15-v" v-show="!codes.length">
    <h2>ไม่มีโค๊ด</h2>
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

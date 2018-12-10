<template>
<div>
  <div class="text-left">
    <button class="btn blue" type="button" @click="formVisible = !formVisible">เพิ่มข้อมูล&nbsp;+</button>
  </div>
  <transition name="fade">
    <form class="toggle-form margin-15-top" v-show="formVisible" @submit.prevent="create()">
      <div class="form-group">
        <label class="full">ประเภท</label>
        <select required class="select-input half-width-res" v-model="sub" @change.prevent="selectType()">
          <option value="phone">โทรศัพท์</option>
          <option value="address">ที่อยู่</option>
          <option value="email">อีเมล</option>
          <option value="facebook">Facebook</option>
          <option value="instagram">Instagram</option>
          <option value="twitter">Twitter</option>
          <option value="line">Line</option>
        </select>
      </div>
      <div class="form-group">
        <label class="full">ชื่อ ที่อยู่ หรือ ข้อมูลอื่น</label>
        <input required class="half-width-res" type="text" v-model="body">
      </div>
      <div class="form-group">
        <label class="full">ลิ้งค์(ไม่มีก็ได้)</label>
        <input data-vv-as="*" v-validate="'url:require_protocol'" class="half-width-res" type="text" name="link" v-model="link" :class="{'error': errors.has('link')}" placeholder="http://www.example.com">
        <span v-show="errors.has('link')" class="error">{{ errors.first('link') }}</span>
      </div>
      <div class="text-right padding-15-top-mobile">
        <button :disabled="errors.any()" type="submit" class="btn blue form-submit">ยืนยัน</button>
      </div>
    </form>
  </transition>
  <div class="padding-15-v contact" v-show="contacts.length">
    <div v-for="(contact, index) in contacts">
      <div class="info">
        <i :class="[contact.sub, contact.type]"></i>
        <p class="body">{{ contact.body }}</p>
      </div>
      <p v-show="contact.link" class="link"><a :href="contact.link">{{ contact.link }}</a></p>
      <div class="actions text-right">
        <button class="btn-flat red fas fa-trash-alt font-large" type="button" @click="remove(contact.id, index)"></button>
      </div>
    </div>
  </div>
  <div v-show="!contacts.length" class="text-center">
    <h2>ไม่มีข้อมูลของร้าน</h2>
  </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      contacts: [],
      type: null,
      sub: null,
      body: null,
      link: null,
      formVisible: false
    }
  },
  methods: {
    getContact() {
      this.$root.loading = true
      axios.get(this.$root.url + '/api/get/contact').then(response => {
        this.contacts = response.data
        this.$root.loading = false
      })
    },
    selectType() {
      this.type = null
      if (['phone', 'address', 'email'].indexOf(this.sub) > -1) {
        this.type = 'contact'
      } else {
        this.type = 'social'
      }
    },
    create() {
      this.$Progress.start()
      axios.post(this.$root.url + '/admin/contact/add', {
        type : this.type,
        sub : this.sub,
        body : this.body,
        link : this.link
      }).then(response => {
        this.contacts.push(response.data)
        this.type = null
        this.body = null
        this.link = null
        toastr.success('เพิ่มข้อมูลแล้ว')
        this.$Progress.finish()
      }, response => {
        toastr.error('เกิดข้อผิดพลาด')
        this.$Progress.stop()
      })
    },
    update(contact) {
      axios.put(this.$root.url + '/admin/contact/update/' + contact.id).then(response => {
        toastr.success('อัพเดทข้อมูลแล้ว')
      }, response => {
        toastr.error('เกิดข้อผิดพลาด')
      })
    },
    remove(id, index) {
      if (confirm('คุณแน่ใจหรือไม่ว่าจะลบ?')) {
        axios.delete(this.$root.url + '/admin/contact/delete/' + id).then(response => {
          this.contacts.splice(index, 1)
          toastr.success('ลบข้อมูลแล้ว')
        }, response => {
          toastr.error('เกิดข้อผิดพลาด')
        })
      }
    }
  },
  created() {
    this.getContact()
  }
}
</script>

<template>
<div>
  <h2 class="page-title">ข้อมูลร้าน
    <back></back>
  </h2>
  <logo></logo>
  <hr>
  <description :old-desc="configs[1].array_value"></description>
  <hr>
  <h3 class="">ช่องทางการติดต่อ</h3>
  <div class="margin-15-bottom">
    <button class="btn primary" type="button" @click="formVisible = !formVisible">เพิ่มช่องทางการติดต่อ&nbsp;<i class="fas fa-plus"></i></button>
  </div>
  <transition name="fade">
    <div class="grid-x margin-15-bottom" v-show="formVisible">
      <form class="filter cell medium-6 grid-y" @submit.prevent="create()">
        <div class="form-group">
          <label>ประเภท</label>
          <select required v-model="sub" @change.prevent="selectType()">
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
          <label>ชื่อ ที่อยู่ หรือ ข้อมูลอื่น</label>
          <input required class="half-width-res" type="text" v-model="body">
        </div>
        <div class="form-group">
          <label>ลิ้งค์(ไม่มีก็ได้)</label>
          <input data-vv-as="*" v-validate="'url:require_protocol'" class="half-width-res" type="text" name="link" v-model="link" :class="{'error': errors.has('link')}" placeholder="http://www.example.com">
          <span v-show="errors.has('link')" class="error">{{ errors.first('link') }}</span>
        </div>
        <div class="grid-x padding-15-top-mobile align-right">
          <button :disabled="errors.any()" type="submit" class="btn success cell medium-4">ยืนยัน</button>
        </div>
      </form>
    </div>
  </transition>
  <table class="stack unstriped hover" v-show="contacts.length">
    <tbody>
      <tr v-for="(contact, index) in contacts">
        <td class="contact-icon" width="50"><i class="contact" :class="[contact.sub, contact.type]"></i></td>
        <td>{{ contact.body }}</td>
        <td v-show="contact.link"><a :href="contact.link">{{ contact.link }}</a></td>
        <td v-show="!contact.link">ไม่มีลิ้งค์</td>
        <td class="text-right">
          <button class="btn error fas fa-trash-alt" type="button" @click="remove(contact.id, index)"></button>
        </td>
      </tr>
    </tbody>
  </table>
  <div v-show="!contacts.length" class="text-center margin-15-v">
    <h2>ไม่มีข้อมูลของร้าน</h2>
  </div>
</div>
</template>

<script>
import Logo from './Logo';
import Description from './Description';
export default {
  components: {
    Logo, Description
  },
  data() {
    return {
      contacts: [],
      configs: [],
      type: null,
      sub: null,
      body: null,
      link: null,
      formVisible: false
    }
  },
  methods: {
    getContact() {
      axios.get(this.$root.url + '/api/get/contact').then(response => {
        this.contacts = response.data
      })
    },
    getConfig() {
      axios.get(this.$root.url + '/admin/info/get_config').then(response => {
        this.configs = response.data
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
    this.$root.loading = true
    this.getContact()
    this.getConfig()
    this.$root.loading = false
  }
}
</script>

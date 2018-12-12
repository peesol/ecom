<template>
<div>
  <a class="login" @click.prevent="open()">LOGIN</a>
  <modal size="login">
    <div slot="heading" class="modal-heading-tab">
      <button :class="{'active' : tab == 'login'}" type="button" @click.prevent="tab = 'login'">Login</button>
      <button :class="{'active' : tab == 'register'}" type="button" @click.prevent="tab = 'register'">Register</button>
    </div>
    <div class="padding-10" slot="body" v-if="tab == 'login'">
      <div>
        <form @submit="login()" method="post">
          <div class="login">
            <div class="form-group">
              <label class="full" for="email">Email</label>
              <input required class="full-width" id="email" type="text" name="user" v-model="email">
              <span class="error" v-show="errors.first('user')">{{ errors.first('user') }}</span>
            </div>
            <div class="form-group padding-10-bottom">
              <label class="full" for="password">Password</label>
              <input required class="full-width" id="password" type="password" v-model="password">
            </div>
            <button class="auth-modal full-width" type="submit" :disabled="!email && !password">LOGIN</button>
          </div>
        </form>
      </div>
      <div class="text-center oauth">
        <h3 class="text-center padding-15-v">Login with</h3>
        <button class="google auth-modal full-width margin-15-bottom" type="button" @click="google()">Google +</button>
        <button class="facebook auth-modal full-width" type="button" @click="facebook()">Facebook</button>
      </div>
    </div>
    <form @submit.prevent="register()" class="padding-10" method="POST" slot="body" v-else>
      <div class="form-group">
        <label class="full">Name</label>
        <input data-vv-as="ชื่อ" required v-validate="'required'" class="full-width" type="text" v-model="form.name" name="name">
        <span class="error" v-show="errors.first('name')">{{ errors.first('name') }}</span>
      </div>
      <div class="form-group">
        <label class="full">Email</label>
        <input @input="checkEmail()" data-vv-as="อีเมล" required v-validate="'required|email'" class="full-width" type="email" v-model="form.email" name="email" placeholder="example@gmail.com">
        <span class="error" v-show="errors.first('email')">{{ errors.first('email') }}</span>
        <span class="error" v-show="emailError">{{ emailError }}</span>
      </div>
      <div class="form-group">
        <label class="full">Password</label>
        <input data-vv-as="รหัสผ่าน" required v-validate="'required|alpha_num|min:6'" class="full-width" type="password" v-model="form.password" name="password" ref="password">
        <span class="error" v-show="errors.first('password')">{{ errors.first('password') }}</span>
      </div>
      <div class="form-group padding-10-bottom">
        <label class="full">Confirm password</label>
        <input data-vv-as="รหัสผ่าน" required v-validate="'required|confirmed:password|min:6'" class="full-width" type="password" name="confirm">
        <span class="error" v-show="errors.first('confirm')">{{ errors.first('confirm') }}</span>
      </div>
      <button :disabled="errors.any()" class="auth-modal full-width" type="submit" name="button">Register</button>
    </form>
  </modal>
</div>
</template>

<script>
export default {
  data() {
    return {
      email: null,
      password: null,
      tab: 'login',
      form: {
        name: null,
        email: null,
        password: null
      },
      emailError: null
    }
  },
  methods: {
    login() {
      this.$root.loading = true
      axios.post(this.$root.url + '/login').then(response => {
        document.location.href = this.$root.url + '/'
      }, response => {
        this.$root.loading = false
        toastr.error('ไม่สามารถล็อกอินได้')
      })
    },
    register() {
      this.$root.loading = true
      axios.post(this.$root.url + '/register', {
        name: this.form.name,
        email: this.form.email,
        password: this.form.password,
        password_confirmation: this.form.password
      }).then(response => {
        document.location.href = this.$root.url + '/'
      }, response => {
        this.$root.loading = false
        toastr.error('ไม่สามารถสมัครสมาชิกได้')
      })
    },
    checkEmail: _.debounce(function () {
      this.emailError = null
      axios.get(this.$root.url + '/api/get/check_email/' + this.form.email).then(response => {
        if (response.data == true) {
          this.emailError = 'อีเมลนี้ถูกใช้ไปแล้ว'
        }
      })
    }, 1000),
    google() {
      document.location.href = this.$root.url + '/google/redirect'
    },
    facebook() {
      document.location.href = this.$root.url + '/facebook/redirect'
    },
    open() {
      this.$root.showModal = true
    },
    hide() {
      this.$root.showModal = false
    },
  }
}
</script>

<template>
<nav>
  <div class="grid-container">
    <div class="left-nav">
      <a class="logo hide-for-small-only" href="#">
        <img src="https://cdn.svgporn.com/logos/angular.svg" alt="">
      </a>
      <a href="/">
        <i class="fas fa-home"></i>
        <font>&nbsp;HOME</font>
      </a>
      <a href="/shop">
        <i class="fas fa-shopping-basket"></i>
        <font>&nbsp;SHOP</font>
      </a>
      <a href="/contact">
        <i class="fas fa-phone"></i>
        <font>&nbsp;CONTACT US</font>
      </a>
      <a v-show="$root.authenticated" href="/cart" @click="goToCart()">
        <i class="fas fa-shopping-cart"></i>
        <font>CART&nbsp;({{count}})</font>
        <span class="cart-count" v-show="count > 0">{{count}}</span>
      </a>
    </div>
    <div class="right-nav">
      <div class="dropdown">
        <a v-show="$root.authenticated" @click="dropdown = !dropdown">
          <i class="fas fa-user"></i>
          <font>ACCOUNT&nbsp;<i class="fas fa-caret-down"></i></font>
        </a>
        <transition name="fade">
          <div class="dropdown-menu" v-show="dropdown && $root.authenticated">
            <a href="/myaccount"><i class="fas fa-user"></i>&nbsp;MY ACCOUNT</a>
            <a href="/order"><i class="fas fa-list"></i>&nbsp;MY ORDERS</a>
            <a @click.prevent="logout()"><i class="fas fa-sign-out-alt"></i>&nbsp;LOGOUT</a>
          </div>
        </transition>
      </div>
      <a v-show="!$root.authenticated" class="login" @click.prevent="openModal()">LOGIN</a>
    </div>
  </div>

  <!-- MODAL -->
  <modal v-show="!$root.authenticated" size="login">
    <div slot="heading" class="modal-heading-tab">
      <button class="half" :class="{'active' : tab == 'login'}" type="button" @click.prevent="tab = 'login'">Login</button>
      <button class="half" :class="{'active' : tab == 'register'}" type="button" @click.prevent="tab = 'register'">Register</button>
    </div>
    <div class="padding-10" slot="body" v-if="tab == 'login'">
      <div>
        <form class="grid-y" @submit.prevent="login()" method="post" action="">
          <div class="login">
            <div class="form-group">
              <label for="email">Email</label>
              <input required class="full-width" id="email" type="text" name="user" v-model="loginForm.email">
              <span class="error" v-show="errors.first('user')">{{ errors.first('user') }}</span>
            </div>
            <div class="form-group padding-10-bottom">
              <label for="password">Password</label>
              <input required class="full-width" id="password" type="password" v-model="loginForm.password">
            </div>
            <button class="cell btn primary" type="submit" :disabled="!loginForm.email || !loginForm.password">LOGIN</button>
          </div>
        </form>
      </div>
      <div class="text-center grid-y">
        <h4 class="text-center padding-15-v">Login with</h4>
        <button class="cell google auth-modal margin-15-bottom" type="button" @click="google()">Google +</button>
        <button class="cell facebook auth-modal" type="button" @click="facebook()">Facebook</button>
      </div>
    </div>
    <form @submit.prevent="register()" class="padding-10" method="POST" action="" slot="body" v-else>
      <div class="form-group">
        <label>Name</label>
        <input data-vv-as="ชื่อ" required v-validate="'required'" class="full-width" type="text" v-model="form.name" name="name">
        <span class="error" v-show="errors.first('name')">{{ errors.first('name') }}</span>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input @input="checkEmail()" data-vv-as="อีเมล" required v-validate="'required|email'" class="full-width" type="email" v-model="form.email" name="email" placeholder="example@gmail.com">
        <span class="error" v-show="errors.first('email')">{{ errors.first('email') }}</span>
        <span class="error" v-show="emailError">{{ emailError }}</span>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input data-vv-as="รหัสผ่าน" required v-validate="'required|alpha_num|min:6'" class="full-width" type="password" v-model="form.password" name="password" ref="password">
        <span class="error" v-show="errors.first('password')">{{ errors.first('password') }}</span>
      </div>
      <div class="form-group padding-10-bottom">
        <label>Confirm password</label>
        <input data-vv-as="รหัสผ่าน" required v-validate="'required|confirmed:password|min:6'" class="full-width" type="password" name="confirm">
        <span class="error" v-show="errors.first('confirm')">{{ errors.first('confirm') }}</span>
      </div>
      <button :disabled="errors.any()" class="cell btn primary" type="submit" name="button">Register</button>
    </form>
    <div class="modal-btn single margin-10-top" slot="footer">
      <button type="button" name="button" @click.prevent="hideModal()">Close&nbsp;<i class="fas fa-times"></i></button>
    </div>
  </modal>
</nav>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  data() {
    return {
      dropdown: false,
      email: null,
      password: null,
      tab: 'login',
      form: {
        name: null,
        email: null,
        password: null
      },
      loginForm: {
        email: null,
        password: null
      },
      emailError: null
    }
  },
  computed: {
    ...mapGetters([
      'count'
    ])
  },
  methods: {
    ...mapActions([
      'getCartCount',
    ]),
    goToCart() {
      document.location.href = this.$root.url + '/cart';
    },
    logout() {
      this.$root.loading = true
      axios.post(this.$root.url + '/logout').then(response => {
        document.location.href = this.$root.url + '/'
        this.$root.loading = false
      }, response => {
        document.location.href = this.$root.url + '/'
        this.$root.loading = false
      })
    },
    /*
    * unauthenticated fucntions
    */
    login() {
      this.$root.loading = true
      axios.post(this.$root.url + '/login', {
        email: this.loginForm.email,
        password: this.loginForm.password,
      }).then(response => {
        document.location.href = this.$root.url + '/'
      }, response => {
        this.$root.loading = false
        toastr.error('ไม่สามารถล็อกอินได้ คุณอาจกรอกข้อมูลผิด')
        console.log(response);
        toastr.error(response.data.errors.email)
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
      document.location.href = this.$root.url + '/oauth/google/redirect'
    },
    facebook() {
      document.location.href = this.$root.url + '/oauth/facebook/redirect'
    },
    openModal() {
      this.$root.showModal = true
    },
    hideModal() {
      this.$root.showModal = false
    },
  },
  created() {
    if (this.$root.authenticated) {
      this.getCartCount()
    }
  }
}
</script>


/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

window.Vue = require('vue');

import VueProgressBar from 'vue-progressbar'
import VeeValidate from 'vee-validate';

import number from './misc/number-filter'
Vue.use(number)

const progressBar = {
  color: '#46ff4a',
  failedColor: '#874b4b',
  thickness: '7px',
}

import thai from 'vee-validate/dist/locale/th';
const dictionary = {
  th: {
    messages: thai.messages,
    attributes: {
      product_name: 'ชื่อสินค้า',
      price: 'ราคาสินค้า',
      description: 'คำอธิบาย',
    }
  }
}
Vue.use(VueProgressBar, progressBar)
Vue.use(VeeValidate, {
  locale: 'th'
});


Vue.component('banner-slick', require('./components/slick/BannerSlick.vue'));
Vue.component('product-slick', require('./components/slick/ProductSlick.vue'));
Vue.component('img-slick', require('./components/slick/ImageSlick.vue'));
Vue.component('add-to-cart', require('./components/cart/AddToCart.vue'));
Vue.component('cart-icon', require('./components/cart/CartIcon.vue'));
Vue.component('cart', require('./components/cart/Cart.vue'));
Vue.component('product-upload', require('./components/admin/UploadProduct.vue'));
Vue.component('category', require('./components/admin/Category.vue'));
Vue.component('product-show', require('./components/product/ProductShow.vue'));
Vue.component('product-edit', require('./components/product/ProductEdit.vue'));
Vue.component('product-photo', require('./components/product/ProductPhoto.vue'));
Vue.component('product-choice', require('./components/product/ProductChoice.vue'));
Vue.component('product-discount', require('./components/promotion/ProductDiscount.vue'));
Vue.component('product-discount', require('./components/promotion/Code.vue'));
Vue.component('product-stock', require('./components/product/ProductStock.vue'));
Vue.component('modal', require('./components/Modal.vue'));

Vue.component('load-overlay', {
  props: ['bg','show', 'padding'],
  template: '<div class="load-overlay" :style="{ padding : padding }" :class="[{show : show}, bg]"><div class="lds-css ng-scope"><div style="width:100%;height:100%" class="lds-ellipsis"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div></div>'
})

// const files = require.context('./', true, /\.vue$/i)

// files.keys().map(key => {
//     return Vue.component(_.last(key.split('/')).split('.')[0], files(key))
// })

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
 import {store} from './store/store'
 import {router} from './route/router'

 window.addEventListener('load', function () {
    const vue = new Vue({
      el: '#app',
      data: {
        url: window.Data.url,
        authenticated: window.Data.user.authenticated,
        role: window.Data.user.role,
        locale: window.Data.locale,
        loading: false,
      },
      store,
      router,
      created() {
        this.$validator.localize(dictionary)
        this.$validator.localize('th')
      }
    })
 });


/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

window.Vue = require('vue');

import VueProgressBar from 'vue-progressbar'
import VeeValidate from 'vee-validate';


const progressBar = {
  color: '#bffaf3',
  failedColor: '#874b4b',
  thickness: '5px',
  transition: {
    speed: '0.2s',
    opacity: '0.6s',
    termination: 300
  },
  autoRevert: true,
  location: 'left',
  inverse: false
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
Vue.component('product-upload', require('./components/product/UploadProduct.vue'));
Vue.component('category', require('./components/product/Category.vue'));

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

 window.addEventListener('load', function () {
    const vue = new Vue({
      el: '#app',
      data() {
        return {
          url: window.Data.url,
          authenticated: window.Data.user.authenticated,
        }
      },
      created() {
        this.$validator.localize(dictionary)
        this.$validator.localize('th')
      }
    })
 });

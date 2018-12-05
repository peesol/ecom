import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

const ProductDiscount = require('../components/promotion/ProductDiscount.vue');
const Code = require('../components/promotion/Code.vue');

const routes = [
  {
    path: '/admin/promotions/discount',
    component: ProductDiscount
  },
  {
    path: '/admin/promotions/code',
    component: Code
  }
];

export const router = new VueRouter({
  mode: 'history',
  routes
})

import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

const ProductShow = require('../components/product/ProductShow.vue');
const ProductEdit = require('../components/product/ProductEdit.vue');
const ProductStock = require('../components/product/ProductStock.vue');
const ProductUpload = require('../components/product/ProductUpload.vue');
const ProductDiscount = require('../components/promotion/ProductDiscount.vue');
const Code = require('../components/promotion/Code.vue');

const routes = [
  {
    path: '/admin/product/upload',
    component: ProductUpload
  },
  {
    path: '/admin/product',
    component: ProductShow
  },
  {
    path: '/admin/product/:uid/edit',
    component: ProductEdit
  },
  {
    path: '/admin/product/stock',
    component: ProductStock
  },
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

import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

const Category = require('../components/product/Category.vue');
const ProductShow = require('../components/product/ProductShow.vue');
const ProductEdit = require('../components/product/ProductEdit.vue');
const ProductStock = require('../components/product/ProductStock.vue');
const ProductUpload = require('../components/product/ProductUpload.vue');
const ProductDiscount = require('../components/promotion/ProductDiscount.vue');
const Code = require('../components/promotion/Code.vue');
const Banner = require('../components/admin/Banner.vue');
const Shipping = require('../components/admin/Shipping.vue');
const Order = require('../components/admin/Order.vue');
const OrderView = require('../components/admin/OrderView.vue');
const Payment = require('../components/admin/Payment.vue');
const Showcase = require('../components/admin/Showcase.vue');
const ShowcaseEdit = require('../components/admin/ShowcaseEdit.vue');

const Contact = require('../components/admin/Info/Contact.vue');

const routes = [
  {
    path: '/admin/category',
    component: Category
  },
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
  },
  {
    path: '/admin/banner',
    component: Banner
  },
  {
    path: '/admin/contact',
    component: Contact
  },
  {
    path: '/admin/shipping',
    component: Shipping
  },
  {
    path: '/admin/orders',
    component: Order
  },
  {
    path: '/admin/orders/:uid',
    component: OrderView
  },
  {
    path: '/admin/payment',
    component: Payment
  },
  {
    path: '/admin/showcase',
    component: Showcase
  },
  {
    path: '/admin/showcase/:showcase/edit',
    component: ShowcaseEdit
  }
];

export const router = new VueRouter({
  mode: 'history',
  routes
})

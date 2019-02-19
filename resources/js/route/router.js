import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

const Dashboard = require('../components/Admin/Dashboard/Dashboard.vue');
const Category = require('../components/Admin/Product/Category.vue');
const ProductShow = require('../components/Product/ProductShow.vue');
const ProductEdit = require('../components/Admin/Product/ProductEdit.vue');
const ProductStock = require('../components/Admin/Product/ProductStock.vue');
const ProductUpload = require('../components/Admin/Product/ProductUpload.vue');
const ProductDiscount = require('../components/Admin/Promotion/ProductDiscount.vue');
const Code = require('../components/Admin/Promotion/Code.vue');
const Banner = require('../components/Admin/Banner.vue');
const Shipping = require('../components/Admin/Shipping.vue');
const Order = require('../components/Admin/Order/Order.vue');
const OrderView = require('../components/Admin/Order/OrderView.vue');
const OrderHistory = require('../components/Admin/Order/OrderHistory.vue');
const Payment = require('../components/Admin/Payment.vue');
const Showcase = require('../components/Admin/Showcase.vue');
const ShowcaseEdit = require('../components/Admin/ShowcaseEdit.vue');

const Contact = require('../components/Admin/Info/Contact.vue');

const routes = [
  {
    path: '/admin',
    component: Dashboard
  },
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
    path: '/admin/orders_history',
    component: OrderHistory
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

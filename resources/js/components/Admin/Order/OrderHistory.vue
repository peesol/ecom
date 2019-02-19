<template>
  <div>
    <h2 class="page-title">ประวัติรายการสั่งซื้อ
      <back></back>
    </h2>
    <div class="padding-10-v">
      <i class="fas fa-circle font-green"></i>&nbsp;ชำระเงินแล้ว / ส่งสินค้าแล้ว<br>
      <i class="fas fa-circle font-red"></i>&nbsp;ปฎิเสธ<br>
      <i class="fas fa-circle font-warning"></i>&nbsp;ยังไม่ชำระเงิน<br>
    </div>
    <div class="grid-x">
      <form class="grid-y filter cell medium-4" action="" @submit.prevent="getOrder()">
        <div class="grid-x grid-margin-x medium-up-2 margin-15-bottom">
          <div class="form-group cell small-4">
            <label>ปี</label>
            <select required class="no-margin" v-model="query.year">
              <option :value="year" v-for="year in years">{{ year }}</option>
            </select>
          </div>
          <div class="form-group cell small-8">
            <label>เดือน</label>
            <select class="no-margin" v-model="query.month">
              <option :value="index + 1" v-for="(month, index) in months">{{ month }}</option>
              <option :value="null">-ไม่เลือกเดือน-</option>
            </select>
          </div>
        </div>
        <div class="cell form-group text-right">
          <button type="submit" class="btn success cell">ค้นหา</button>
        </div>
      </form>
    </div>
    <p class="lead no-margin padding-15-top">พบ&nbsp;{{ meta.total }}&nbsp;รายการ&nbsp;{{ meta.last_page }}&nbsp;หน้า</p>
    <pagination :meta="meta" v-on:switched="changePage" v-show="orders.length"></pagination>
    <table class="unstriped hover">
      <thead>
        <tr>
          <th>รายการ</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="order in orders">
          <td>
            <a :href="'/admin/orders/' + order.uid"><i class="fas fa-circle" :class="orderStatus(order)"></i>&nbsp;{{ order.title }}</a>
          </td>
        </tr>
      </tbody>
    </table>
    <pagination :meta="meta" v-on:switched="changePage" v-show="orders.length"></pagination>
  </div>
</template>

<script>
import Pagination from '../../Partials/Pagination'
export default {
  components: {
    Pagination
  },
  data() {
    return {
      orders: [],
      meta: [],
      query: {
        page: null,
        month: null,
        year: null
      },
      months: [
        'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤษจิกายน', 'ธันวาคม'
      ]
    }
  },
  computed : {
  years () {
    const year = new Date().getFullYear()
      return Array.from({length: year - (year - 10)}, (value, index) => (year - 9) + index).reverse()
    }
  },
  methods: {
    orderStatus(order) {
      if (!order.cancle && order.status.paid || order.status.shipped) {
        return 'font-green';
      }
      if (!order.paid && !order.cancle) {
        return 'font-warning';
      }
      if (order.cancle) {
        return 'font-red';
      }
    },
    getOrder() {
      this.$root.loading = true
      axios.get(this.$root.url + '/api/get/order_history', {
        params: {
          page: this.query.page ? this.query.page : 1,
          month: this.query.month,
          year: this.query.year,
        }
      }).then(response => {
        this.orders = response.data.data
        this.meta = response.data.meta
        this.$root.loading = false
      })
    },
    changePage(page) {
      this.query.page = page
      this.getOrder()
    }
  },
  created() {
    this.getOrder()
  }
}
</script>

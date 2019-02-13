<template>
  <div>
    <h2 class="page-title">รายการสั่งซื้อ
      <back></back>
    </h2>
    <section class="padding-15-v">
      <table class="unstriped">
        <thead>
          <tr>
            <th class="toggle-th" :class="{'active' : tab == 1}" @click="toggleTab(1)">
              <i class="label" :class="{'active' : orderCount.ordered > 0}">{{ orderCount.ordered }}</i>
              &nbsp;ยังไม่ชำระเงิน&nbsp;<i class="fas fa-angle-down"></i>
            </th>
          </tr>
        </thead>
        <tbody v-show="tab == 1">
          <tr v-for="order in orders" v-show="!order.status.paid">
            <td><i class="fas fa-times font-red" v-show="order.cancle"></i>&nbsp;<a :href="'/admin/orders/' + order.uid">{{ order.title }}</a></td>
          </tr>
        </tbody>
        <thead>
          <tr>
            <th class="toggle-th" :class="{'active' : tab == 2}" @click="toggleTab(2)">
              <i class="label" :class="{'active' : orderCount.paid > 0}">{{ orderCount.paid }}</i>
              &nbsp;ชำระเงินแล้ว&nbsp;<i class="fas fa-angle-down"></i>
            </th>
          </tr>
        </thead>
        <tbody v-show="tab == 2">
          <tr v-for="order in orders" v-show="order.status.paid && !order.status.shipped">
            <td><i class="fas fa-times font-red" v-show="order.cancle"></i>&nbsp;<a :href="'/admin/orders/' + order.uid">{{ order.title }}</a></td>
          </tr>
        </tbody>
        <thead>
          <tr>
            <th class="toggle-th" :class="{'active' : tab == 3}" @click="toggleTab(3)">
              <i class="label" :class="{'active' : orderCount.shipped > 0}">{{ orderCount.shipped }}</i>
              &nbsp;จัดส่งแล้ว&nbsp;<i class="fas fa-angle-down"></i>
            </th>
          </tr>
        </thead>
        <tbody v-show="tab == 3">
          <tr v-for="order in orders" v-show="order.status.paid && order.status.shipped">
            <td><i class="fas fa-times font-red" v-show="order.cancle"></i>&nbsp;<a :href="'/admin/orders/' + order.uid">{{ order.title }}</a></td>
          </tr>
        </tbody>
      </table>
    </section>
  </div>
</template>

<script>
export default {
  data() {
    return {
      orders: [],
      tab: null
    }
  },
  computed: {
    orderCount: function () {
      var ordered = 0;
      var paid = 0;
      var shipped = 0;
      this.orders.forEach(function (item) {
        if(!item.status.paid) { ordered++; }
        if(item.status.paid && !item.status.shipped) { paid++; }
        if(item.status.shipped) { shipped++; }
      });
      return { paid, ordered, shipped};
    }
  },
  methods: {
    getOrder() {
      axios.get( this.$root.url + '/api/get/order').then(response => {
        this.orders = response.data
      })
    },
    toggleTab(id) {
      if (this.tab == id) {
        this.tab = null
      } else {
        this.tab = id
      }
    }
  },
  created() {
    this.$root.loading = true
    this.getOrder()
    this.$root.loading = false
  }

}
</script>

<template>
<div>
  <h2 class="page-title">รายการสั่งซื้อ
    <back></back>
  </h2>
  <h3>#{{ order.uid }}</h3>

  <label class="status warning margin-15-bottom" v-show="!order.status.paid && !order.cancle">ยังไม่ชำระเงิน</label>
  <label class="status success margin-15-bottom" v-show="order.status.paid && order.status.shipped && !order.cancle">ส่งสินค้าแล้ว</label>
  <label class="status success margin-15-bottom" v-show="order.status.paid && !order.status.shipped && !order.cancle">เตรียมจัดส่ง</label>

  <h4 class="font-red" v-show="order.cancle">รายการนี้ถูกปฏิเสธแล้ว</h4>
  <button class="btn error margin-15-bottom" @click.prevent="formVisible = !formVisible" v-show="!order.cancle && !order.status.shipped" style="width:150px">ปฏิเสธรายการนี้</button>
  <transition name="fade">
  <form class="grid-x margin-15-bottom" method="" @submit.prevent="deny(order.uid)" v-show="formVisible && !order.cancle">
    <div class="cell medium-5 filter form-group">
      <label>เหตุผลการปฏิเสธ</label>
      <input required type="text" v-model="deny_message">
      <div class="text-right">
        <button class="btn success" type="submit">ยืนยัน</button>
      </div>
    </div>
  </form>
</transition>
  <p class="no-margin">ที่อยู่ในการจัดส่ง</p>
  <p>{{ order.address }}</p>
  <table class="stack unstriped margin-15-v">
    <thead>
      <tr>
        <th>สินค้า</th>
        <th>ราคา</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="item in order.body">
        <td>
          <img :src="imgUrl + item.thumbnail" alt="img" style="width:60px;margin-right:8px">
          {{ item.name }}{{ ' - ' + item.options.choice ? item.options.choice : '' }}
        </td>
        <td><font class="show-for-small-only">ราคา</font>&nbsp;{{ $number.currency(item.price) }}&nbsp;฿ &times;&nbsp;{{ item.qty }}</td>
      </tr>
    </tbody>
  </table>
  <h3 class="font-green">ยอดชำระ&nbsp;{{ $number.currency(order.total) }}&nbsp;฿</h3>
  <p>ค่าจัดส่ง&nbsp;{{ $number.currency(order.fee ? order.fee : 'FREE') }}</p>
</div>
</template>

<script>
export default {
  data() {
    return {
      order: {},
      deny_message: null,
      formVisible: false,
      imgUrl: this.$root.url + '/file/product/thumbnail/'
    }
  },
  methods: {
    getOrder() {
      this.$root.loading = true
      axios.get(this.$root.url + '/api/get/order/' + this.$route.params.uid).then(response => {
        this.order = response.data
        this.$root.loading = false
      })
    },
    deny(uid) {
      if (confirm('คุณแน่ใจหรือไม่ว่าจะปฏิเสธรายการนี้?')) {
        axios.put(this.$root.url + '/admin/orders/' + uid + '/deny', {
          message: this.deny_message
        }).then(response => {
          toastr.success('ปฏิเสธรายการนี้แล้ว')
          this.order.cancle = this.deny_message
        }, response => {
          toastr.error('เกิดข้อผิดพลาด')
        })
      }
    }
  },
  created() {
    this.getOrder()
  }
}
</script>

<template>
<div class="">
  <h2 class="page-title">หน้าแรก</h2>
  <div class="grid-x medium-up-2 grid-padding-x">
    <div class="cell">
      <h3>ยอดขาย</h3>
      <p class="lead">เดือนนี้</p>
      <p class="stat" :class="{'font-green' : salesCalc(monthly) !== 0 }">{{ salesCalc(monthly) }}&nbsp;<small style="font-size:1.5rem">บาท</small></p>
      <p class="lead">ปีนี้</p>
      <p class="stat" :class="{'font-green' : salesCalc(yearly) !== 0 }">{{ salesCalc(yearly) }}&nbsp;<small style="font-size:1.5rem">บาท</small></p>
      <p class="lead">รายการสั่งซื้อในเดือนนี้</p>
      <p class="stat" :class="{'font-green' : monthly_count > 0 }">{{ monthly_count }}&nbsp;<small style="font-size:1.5rem">รายการ</small></p>
    </div>
    <div class="cell">
      <product :chartdata="graph"></product>
    </div>
  </div>
  <hr>
  <div class="grid-x medium-up-2 grid-padding-x">
    <div class="cell">
      <h3>สินค้าที่ถูกเข้าชมมากที่สุด</h3>
      <p v-for="(item, index) in products">{{ (index + 1) + '. ' + item.name }}</p>
    </div>
  </div>
</div>
</template>

<script>
import Product from './ProductChart'

export default {
  components: {
    Product
  },
  data() {
    return {
      monthly_count: null,
      monthly: {},
      yearly: {},
      products: null,
      graph: {
        labels: [],
        datasets: [{
          label: 'ยอดขาย',
          backgroundColor: '#6dc55a',
          data: []
        }]
      },
    }
  },
  methods: {
    getData() {
      this.$root.loading = true
      axios.get(this.$root.url + '/admin/get_data').then(response => {
        this.monthly_count = response.data.count
        this.monthly = response.data.monthly
        this.yearly = response.data.yearly
        this.products = response.data.products
        this.assignValues(response.data.graph)
        this.$root.loading = false
      })
    },
    salesCalc(data) {
      var total = [];
      if (Object.keys(data).length) {
        Object.entries(data).forEach(([key, val]) => {
          total.push(parseInt(val.total))
        });
        var sales = total.reduce(function(total, num){ return total + num }, 0)
        return this.$number.currency(sales);
      } else {
        return 0;
      }
    },
    assignValues(data) {
      var labels = [];
      var datas = [];
      Object.entries(data).forEach(([key, val]) => {
        labels.push(key)
        datas.push(val)
      });
      this.graph.labels = labels
      this.graph.datasets[0].data = datas
    }
  },
  created() {
    this.getData()
  }
}
</script>

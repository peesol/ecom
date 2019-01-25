<template>
  <div>
    <h2 class="page-title">ออเดอร์
      <back></back>
    </h2>
    <section>
      <table>
        <thead>
          <tr>
            <th>ยังไม่ชำระเงิน</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order in orders">
            <td><a href="#"></a></td>
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
    }
  },
  methods: {
    
  }

}
</script>

<template>
<div>
  <h2 class="page-title">ช่องทางการชำระเงิน
    <back></back>
  </h2>
  <button class="btn primary margin-10-top" @click.prevent="formVisible = !formVisible">เพิ่มช่องทางชำระเงิน&nbsp;<i class="fas fa-plus"></i></button>
  <transition name="fade">
    <form class="grid-x margin-15-top" method="post" v-show="formVisible" @submit.prevent="addPayment()">
      <div class="cell medium-5 filter">
        <div class="form-group">
          <label>ประเภท</label>
          <select required v-model="form.method">
            <option value="บัญชีธนาคาร">บัญชีธนาคาร</option>
            <option value="PromptPay">PromptPay</option>
          </select>
        </div>
        <transition name="fade">
          <div class="form-group" v-show="form.method">
            <label>ธนาคาร</label>
            <select required v-model="form.provider">
              <option :value="bank.name" v-for="bank in providers">{{ bank.name }}</option>
            </select>
            <label>เลขที่บัญชี</label>
            <input required type="text" v-model="form.ref" placeholder="ถ้ามีสัญลักษณ์โปรดกรอกให้ครบ">
          </div>
        </transition>
        <transition name="fade">
          <div class="align-right cell grid-x padding-10-top" v-show="form.method && form.provider && form.ref">
            <button class="btn success small-12 medium-4" type="submit">ยืนยัน</button>
          </div>
        </transition>
      </div>
    </form>
  </transition>
  <table class="unstriped stack hover margin-15-top">
    <thead>
      <tr>
        <th>ธนาคาร</th>
        <th>ประเภท</th>
        <th>เลขที่</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(account, index) in accounts">
        <td>{{ account.provider }}</td>
        <td>{{ account.method == 'account' ? 'บัญชีธนาคาร' : 'PromptPay' }}</td>
        <td>
          {{ account.ref }}
        </td>
        <td class="text-right"><button class="btn error fas fa-trash-alt" type="button" @click="remove(account.id, index)"></button></td>
      </tr>
    </tbody>
  </table>
  <div class="text-center padding-15-v" v-show="!accounts.length">
    <h3>ไม่มีช่องทางการชำระเงิน</h3>
  </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      accounts: [],
      form: {
        ref: null,
        method: null,
        provider: null,
      },
      formVisible: false,
      providers: [{
        'name': 'ธนาคารกรุงเทพ',
        'code': 'BBL'
      },
      {
        'name': 'ธนาคารกสิกรไทย',
        'code': 'KBANK'
      },
      {
        'name': 'ธนาคารกรุงไทย',
        'code': 'KTB'
      },
      {
        'name': 'ธนาคารไทยพาณิชย์',
        'code': 'SCB'
      },
      {
        'name': 'ธนาคารทหารไทย',
        'code': 'TMB'
      },
      {
        'name': 'ธนาคารออมสิน',
        'code': 'GSB'
      },
      {
        'name': 'ธนาคารกรุงศรีอยุธยา',
        'code': 'BAY'
      }],
    }
  },
  methods: {
    getPaymentMethod() {
      axios.get(this.$root.url + '/api/get/payment_methods').then(response => {
        this.accounts = response.data
      })
    },
    addPayment() {
      axios.post(this.$root.url + '/admin/payment/create', {
        ref: this.form.ref,
        method: this.form.method,
        provider: this.form.provider
      }).then(response => {
        this.accounts.push(response.data)
        toastr.success('เพิ่มช่องทางชำระเงินแล้ว')
        this.form.ref = null,
        this.form.method = null,
        this.form.provider = null
      }, response => {
        toastr.error('เกิดข้อผิดพลาด')
      })
    },
    remove(id, index) {
      if (confirm('คุณแน่ใจหรือไม่ว่าจะลบ?')) {
        axios.delete(this.$root.url + '/admin/payment/delete/' + id).then(response => {
          this.accounts.splice(index, 1)
          toastr.success('ลบบัญชีเรียบร้อยแล้ว')
        }, response => {
          toastr.error('เกิดข้อผิดพลาด')
        })
      }
    }
  },
  created() {
    this.getPaymentMethod()
  }
}
</script>

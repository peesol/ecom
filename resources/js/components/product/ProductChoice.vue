<template>
<div >
  <h3>ตัวเลือกสินค้า</h3>

    <div class="form-group">
      <label for="name" class="lead">เพิ่มตัวเลือก&nbsp;<small>เช่น สี ไซส์</small></label>
        <div class="grid-x">
          <input required class="form-input medium-3 no-margin small-8" type="text" v-model="name" name="name">
          <button :disabled="$root.loading" class="btn primary medium-1 small-4" type="button" @click.prevent="add">เพิ่ม&nbsp;<small class="fas fa-plus"></small></button>
        </div>
    </div>

  <div v-if="choices.length">
    <p class="lead no-margin padding-10-v">ตัวเลือกของสินค้านี้</p>
    <table class="unstriped">
      <tbody>
        <tr v-for="(choice, index) in choices">
          <td>{{ index + 1 }}.&nbsp;{{choice.name}}</td>
          <td class="font-large"><button @click.prevent="remove(index)" class="btn-flat error" type="button">ลบ</button></td>
        </tr>
      </tbody>
    </table>
  </div>

</div>
</template>

<script>
export default {
  data() {
    return {
      choices: [],
      name: null
    }
  },

  methods: {
    getChoice() {
      axios.get(this.$root.url + '/admin/product/' + this.$route.params.uid + '/get_choice').then(response => {
        this.choices = response.data;
      });
    },

    add() {
      this.$root.loading = true
      this.choices.push({name: this.name})
      this.name = null
      axios.put(this.$root.url + '/admin/product/' + this.$route.params.uid + '/add_choice', {
        choices: this.choices
      }).then(response => {
        toastr.success('เพิ่มตัวเลือกแล้ว')
        this.$root.loading = false
      }, response => {
        this.$root.loading = false
        toastr.error('เกิดข้อผิดพลาด')
      });
    },

    remove(index) {
      if (!confirm('คุณแน่ใจหรือไม่ที่จะลบ?')) {
        return;
      }
      this.choices.splice(index, 1)
      axios.put(this.$root.url + '/admin/product/' + this.$route.params.uid + '/delete_choice', {
        choices: this.choices
      }).then(response => {
        toastr.success('ลบตัวเลือกแล้ว')
      }, response => {
        toastr.error('เกิดข้อผิดพลาด')
      });
    },

  },

  mounted() {
    this.getChoice();
  }

}
</script>

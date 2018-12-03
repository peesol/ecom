<template>
<div class="padding-15-top padding-30">
  <h2>ตัวเลือกสินค้า</h2>
  <div class="half-width-res">
    <form class="form-group">
      <label for="name" class="full-label input-label">เพิ่มตัวเลือก&nbsp;
        <span class="font-light">เช่น สี ไซส์</span>
      </label>
        <form class="input-group margin-10-top" @submit.prevent="add">
          <input required class="input-addon-field" type="text" v-model="name" name="name">
          <button :disabled="$root.loading" class="btn blue" type="submit">เพิ่ม&nbsp;<i class="fas fa-plus"></i></button>
        </form>
    </form>
  </div>

  <div class="half-width-res" v-if="choices.length">
    <h3 class="full-label input-label padding-15-vertical">ตัวเลือกของสินค้านี้</h3>
    <div class="col-2-flex-res border-bottom-grey padding-5" v-for="(choice, index) in choices">
      <div class="list">
        <p>{{ index + 1 }}.&nbsp;{{choice.name}}</p>
      </div>
      <div class="text-right">
        <button @click.prevent="remove(index)" class="btn-flat red" type="button">ลบ</button>
      </div>
    </div>
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

  props: ['productSlug'],

  methods: {
    getChoice() {
      axios.get(this.$root.url + '/admin/product/' + this.productSlug + '/get_choice').then(response => {
        this.choices = response.data;
      });
    },

    add() {
      this.$root.loading = true
      this.choices.push({name: this.name})
      this.name = null
      axios.put(this.$root.url + '/admin/product/' + this.productSlug + '/add_choice', {
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
      axios.put(this.$root.url + '/admin/product/' + this.productSlug + '/delete_choice', {
        choices: this.choices
      }).then(response => {
        toastr.success('ลบตัวเลือกแล้ว')
      }, response => {
        toastr.error('เกิดข้อผิดพลาด')
      });
    },

  },

  created() {
    this.getChoice();
  }

}
</script>

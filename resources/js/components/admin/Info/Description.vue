<template>
  <div>
    <h3>คำอธิบายเว็บไซต์</h3>
    <div class="grid-x">
			<form @submit.prevent="update" method="post" class="medium-6 cell">
				<div class="cell">
          <textarea class="description-input" name="description" rows="8" cols="80" placeholder="เขียนคำอธิบายที่นี่" v-model="description"></textarea>
				</div>
				<div class="align-right form-group grid-x">
          <button :disabled="$root.loading || errors.any()" type="submit" class="btn success cell medium-4">บันทึก</button>
				</div>
			</form>
		</div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      description: this.oldDesc,
    }
  },
  props: ['oldDesc'],
  methods: {
    update() {
      axios.put(this.$root.url + '/admin/info/description/update', {
        description: this.description
      }).then(response => {
        toastr.success('บันทึกข้อมูลแล้ว')
      }, response => {
        toastr.error('เกิดข้อผิดพลาด')
      })
    }
  }
}
</script>

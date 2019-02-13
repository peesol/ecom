<template>
<div>
  <h3 class="padding-10-top">โลโก้เว็บไซต์</h3>
		<div class="grid-x">
			<form @submit.prevent="upload" method="post" class="medium-6 cell">
				<div class="grid-x medium-up-2">
					<div class="cell">
						<p class="lead no-margin text-center">รูปตัวอย่าง</p>
						<div class="image-preview">
							<span class="fas fa-images"></span>
							<img :src="image_filename">
						</div>
					</div>
					<div class="cell grid-y padding-15-v">
						<label class="btn primary margin-15-v text-center">
							<input class="hide" id="image-input" @change="preview" type="file" :name="image_filename" accept="image/*">เลือกไฟล์&nbsp;+
						</label>
						<button class="btn primary margin-15-bottom" v-if="image_filename !== null" @click.prevent="removeFile">ลบ</button>

						<div class="form-group">
              <button :disabled="$root.loading || errors.any() || !image_filename" type="submit" class="btn success cell medium-4">อัพโหลด</button>
						</div>
					</div>
				</div>
			</form>
		</div>
</div>
</template>

<script>
export default {
	data() {
		return {
      banners: [],
			formVisible: false,
			image_filename: '/file/logo/logo.jpg',
			imgUrl: this.$root.url + '/file/logo/'
		}
	},
	methods: {
		preview(event) {
			var input = event.target;
			if (input.files && input.files[0]) {
				if (input.files[0].size > 1048576) {
					alert('ขนาดไฟล์ต้องไม่เกิน 1 MB');
					this.removefile()
				}
				var reader = new FileReader();
				var vm = this;
				reader.onload = function(e) {
					vm.image_filename = e.target.result;
				}
				reader.readAsDataURL(input.files[0]);
			}
		},
		removeFile() {
			this.image_filename = null;
		},
		upload() {
      this.$root.loading = true
			if (document.getElementById("image-input").files.length > 0) {
				axios.put(this.$root.url + '/admin/info/logo/update', {
					logo: this.image_filename
				}).then(response => {
					toastr.success('อัพโหลดโลโก้แล้ว')
          this.image_filename = null
					document.location.href = this.$root.url + '/admin/contact'
				}, response => {
          this.$root.loading = false
					toastr.error('เกิดข้อผิดพลาด')
				})
			}
		}
	},
	created() {
		this.$root.loading = true
		this.$root.loading = false
	}
}
</script>

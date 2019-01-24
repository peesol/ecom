<template>
<div>
	<h2 class="page-title">แบนเนอร์
		<back></back>
	</h2>
	<button class="btn primary margin-10-top" type="button" @click.prevent="formVisible = !formVisible">อัพโหลดแบนเนอร์&nbsp;<i class="fas fa-plus"></i></button>
	<transition name="fade">
		<div class="grid-x" v-show="formVisible">
			<form @submit.prevent="upload" method="post" class="margin-15-top filter medium-6 cell">
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
							<label class="full">ลิ้งค์&nbsp;(ไม่มีก็ได้)</label>
							<input v-model="form.link" data-vv-as="*" v-validate="'url'" class="full-width" type="text" name="link" placeholder="https://www.example.com">
							<span class="error" v-show="errors.first('link')">{{ errors.first('link') }}</span>
						</div>
					</div>
				</div>
				<div class="grid-x align-right">
					<button :disabled="$root.loading || errors.any() || !image_filename" type="submit" class="btn success cell medium-4">อัพโหลด</button>
				</div>
			</form>
		</div>
	</transition>

	<div v-show="banners.length">
    <h2 class="padding-5-top">แบนเนอร์บนหน้าแรก</h2>
		<div class="padding-15-v thumbnail-grid">
			<div class="thumbnail-wrapper fit" v-for="(banner, index) in banners">
        <div class="thumbnail-img-wrapper">
          <img :src="imgUrl + banner.filename" alt="img">
          <button v-show="banner.id" @click.prevent="removeBanner(banner.id, index)" class="top-right btn red"><i class="fas fa-trash-alt"></i></button>
        </div>
			</div>
		</div>
	</div>
	<div class="padding-15-v text-center" v-show="!banners.length">
    <h3>คุณไม่มีแบนเนอร์บนหน้าแรก</h3>
	</div>
</div>
</template>

<script>
export default {
	data() {
		return {
      banners: [],
			formVisible: false,
			image_filename: null,
			imgUrl: this.$root.url + '/file/banner/home/',
      form: {
        link: null
      }
		}
	},
	methods: {
		getBanner() {
			axios.get(this.$root.url + '/api/get/banner').then(response => {
				this.banners = response.data
			})
		},
		preview(event) {
			var input = event.target;
			if (input.files && input.files[0]) {
				if (input.files[0].size > 1048576) {
					alert(this.$trans.translation.file_size_limit + ' 1 MB');
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
				axios.post(this.$root.url + '/admin/banner/create', {
					image: this.image_filename,
          link: this.form.link
				}).then(response => {
					toastr.success('อัพโหลดแบนเนอร์แล้ว')
          this.image_filename = null
          this.form.link = null
					document.location.href = this.$root.url + '/admin/banner'
				}, response => {
          this.$root.loading = false
					toastr.error('เกิดข้อผิดพลาด')
				})
			}
		},
    removeBanner(id, index) {
      if (confirm('คุณแน่ใจหรือไม่ว่าจะลบ?')) {
        this.$root.loading = true
        axios.delete(this.$root.url + '/admin/banner/delete/' + id).then(response => {
          toastr.success('ลบแบนเนอร์แล้ว')
          this.$root.loading = false
          this.banners.splice(index, 1)
        }, response => {
          this.$root.loading = false
          toastr.error('เกิดข้อผิดพลาด')
        })
      }
    }
	},
	created() {
		this.getBanner()
	}
}
</script>

<template>
<div>
	<h2 class="page-title">หมวหมู่สินค้า
		<back></back>
	</h2>
	<button @click.prevent="formVisible = !formVisible" class="btn primary margin-10-top">เพิ่มหมวดหมู่&nbsp;<i class="fas fa-plus"></i></button>
	<div class="padding-15-bottom grid-x">
		<transition name="fade">
			<div v-show="formVisible" class="filter margin-15-top cell medium-5">
				<form @submit.prevent="submit">
					<div class="form-group cell">
						<label class="full">ชื่อหมวดหมู่</label>
						<input required type="text" name="name" v-model="form.name">
					</div>
					<div class="form-group cell">
						<label class="lead">มีหมวดหมู่ย่อยหรือไม่</label>
						<input class="radio" id="yes" type="radio" name="sub" v-model="form.hasSub" :value="true">
						<label class="radio" for="yes">มี</label>
						<input class="radio" id="no" type="radio" name="sub" v-model="form.hasSub" :value="false">
						<label class="radio" for="no">ไม่มี</label>
					</div>
					<div class="form-group cell" v-show="form.hasSub">
						<label class="lead">ชื่อหมวดหมู่ย่อย</label>
						<div class="grid-x">
							<input class="cell medium-9 small-8 no-margin" type="text" name="name" v-model="subName">
							<button :disabled="!subName" type="button" class="cell medium-auto btn primary small-4" @click.prevent="addSub">เพิ่ม&nbsp;<small class="fas fa-plus"></small></button>
						</div>
					</div>
					<div class="form-group" v-show="form.hasSub && form.sub.length">
						<p>หมวดหมู่ย่อย</p>
						<li class="number" v-for="sub in form.sub">{{ sub }}</li>
					</div>
					<div class="grid-x align-right padding-15-top">
						<button type="submit" class="btn success medium-4 cell">ยืนยัน</button>
					</div>
				</form>
			</div>
		</transition>
	</div>
	<div v-if="categories.length">
		<h3>หมวดหมู่ของคุณ</h3>
		<table class="stack hover unstriped">
			<tbody>
				<tr v-for="(category, index) in categories">
					<td v-show="editForm !== index">
						<p>{{ index + 1 }}.&nbsp;{{ category.name }}</p>
						<li class="dash" v-for="sub in category.subcategory">{{ sub.name }}</li>
					</td>
          <transition name="fade">
          <td v-show="editForm == index">
            <div>
              <div class="form-group">
                <label class="full">ชื่อหมวดหมู่</label>
                <input type="text" v-model="category.name">
              </div>
              <div class="form-group" v-show="category.subcategory.length">
                <label class="full">หมวดหมู่รอง</label>
                <input class="margin-10-bottom" type="text" v-for="sub in category.subcategory" v-model="sub.name">
              </div>
            </div>
            <div class="text-right" v-show="editForm == index">
              <button type="button" class="btn success" @click.prevent="submitEdit(category)">บันทึก</button>
              <button type="button" class="btn primary" @click.prevent="cancleEdit()">ยกเลิก</button>
            </div>
          </td>
          </transition>
					<td>

            <div class="text-right" v-show="editForm !== index">
              <button @click.prevent="edit(index, category.id)" class="btn-flat primary padding-10-h" type="button">แก้ไข</button>
              <button @click.prevent="remove(index, category.id)" class="btn-flat error padding-10-h" type="button">ลบ</button>
            </div>
          </td>
				</tr>
			</tbody>
		</table>
	</div>
	<div v-else>
		<h3 class="text-center">คุณไม่มีหมวดหมู่เลย</h3>
	</div>
</div>
</template>

<script>
export default {
	data() {
		return {
			categories: [],
			subName: null,
			form: {
				name: null,
				hasSub: false,
				sub: [],
			},
			formVisible: false,
			editForm: null,
		}
	},
	props: ['categoriesProp'],
	methods: {
		getCategory() {
			axios.get(this.$root.url + '/api/get/category').then(response => {
				this.categories = response.data
			})
		},
		addSub() {
			this.form.sub.push(this.subName)
			this.subName = null
		},
		submit() {
			if (this.form.hasSub && !this.form.sub.length) {
				alert('ถ้าหากไม่มีหมวดหมู่ย่อย โปรดเลือก ไม่มี')
			} else {
				axios.post(this.$root.url + '/admin/category/add', {
					category_name: this.form.name,
					subs: this.form.sub,
					hasSub: this.form.hasSub,
				}).then(response => {
					toastr.success('เพิ่มหมวดหมู่แล้ว')
					this.form.hasSub = false
					this.form.sub = []
					this.form.name = null
					this.categories.push(response.data)
				}, response => {
					toastr.error('เกิดข้อผิดพลาด')
				})
			}
		},
		edit(index, id) {
			this.editForm = index
		},
		submitEdit(category) {
			axios.put(this.$root.url + '/admin/category/update', {
				category: category
			}).then(response => {
				toastr.success('บันทึกแล้ว')
				this.editForm = null
			}, response => {
				toastr.error('เกิดข้อผิดพลาด')
			})
		},
		cancleEdit() {
			this.editForm = null
		},
		remove(index, id) {
			if (confirm('ถ้าคุณลบหมวดหมู่นี้ สินค้าทั้งหมดที่อยู่ในหมวดหมู่นี้รวมถึงหมวดหมู่ย่อยจะถูกลบด้วย คุณแน่ใจหรือไม่?')) {
				axios.delete(this.$root.url + '/admin/category/delete/' + id).then(response => {
					toastr.success('ลบหมวดหมู่เรียบร้อยแล้ว')
					this.categories.splice(index, 1)
				}, response => {
					toastr.error('เกิดข้อผิดพลาด')
				})
			}
		}
	},
	created() {
		this.getCategory()
	}
}
</script>

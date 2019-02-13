<template>
<div>
	<h2 class="page-title">ตู้แสดงสินค้า
		<back></back>
	</h2>
	<button class="btn primary margin-10-top" type="button" @click.prevent="formVisible = !formVisible">สร้างตู้แสดงสินค้า&nbsp;<i class="fas fa-plus"></i></button>
	<transition name="fade">
		<div class="grid-x" v-show="formVisible">
			<form @submit.prevent="create" method="post" class="margin-15-top filter medium-6 cell">
				<div class="cell form-group">
					<label>ชื่อตู้แสดงสินค้า</label>
					<input type="text" v-model="form.name" placeholder="เช่น ลดราคา, คอลเล็คชั่นใหม่">
				</div>
				<div class="grid-x align-right">
					<button :disabled="$root.loading || errors.any()" type="submit" class="btn success cell medium-4">ยืนยัน</button>
				</div>
			</form>
		</div>
	</transition>
  <h3 class="margin-15-v">
		ตู้แสดงสินค้าในร้าน<br>
		<small class="subheader h6">*จัดลำดับโดยการคลิก <i class="btn-flat secondary fas fa-caret-square-down"></i> หรือ <i class="btn-flat secondary fas fa-caret-square-up"></i></small>
	</h3>
	<table class="margin-15-top stack unstriped">
		<tbody>
			<tr class="grid-x align-center-middle" v-for="(showcase, index) in showcases">
				<td class="cell shrink">
						<button class="btn-flat secondary fas fa-caret-square-down padding-5-h" :class="{'not-visible' : (index + 1) >= showcases.length}" @click="setArrayDown(index, showcase.order)"></button>
						{{ index + 1 }}
						<button class="btn-flat secondary fas fa-caret-square-up padding-5-h" :class="{'not-visible' : (index + 1) <= 1}" @click="setArrayUp(index, showcase.order)"></button>
						<a class="padding-15-h fas" :class="{'fa-check font-green': showcase.show, 'fa-times font-red': !showcase.show}" @click.prevent="showToggle(showcase.id, index)">&nbsp;หน้าแรก</a>
        </td>
				<td class="cell auto">{{ showcase.name }}</td>
        <td class="cell shrink text-right-res">
					<router-link :to="{ path: '/admin/showcase/'+ showcase.id +'/edit', params: { showcase: showcase.id }}" class="btn primary fas fa-pen"></router-link>
          <button class="btn error fas fa-trash-alt" type="button" @click="remove(showcase.id, index)"></button>
        </td>
			</tr>
		</tbody>
	</table>
</div>
</template>

<script>
export default {
	data() {
		return {
			name: null,
			showcases: [],
			formVisible: false,
			form: {
				name: null
			}
		}
	},
	methods: {
		setArrayDown(index, order) {
      let array = [this.showcases[index], this.showcases[index + 1]];
      this.showcases.splice(index, 2, array[1], array[0] );
			this.saveOrder()
    },
		setArrayUp(index, order) {
			let array = [this.showcases[index], this.showcases[index + 1], this.showcases[index - 1]];
			if (index < this.showcases.length - 1) {
				this.showcases.splice(index - 1, 3, array[0], array[2], array[1]);
				this.saveOrder()
			} else if (index === this.showcases.length - 1 && this.showcases.length !== 2) {
				this.showcases.splice(index - 1, this.showcases.length - 1, array[0], array[2]);
				this.saveOrder()
			} else if (this.showcases.length === 2) {
				this.showcases.splice(index - 1, this.showcases.length, array[0], array[2]);
				this.saveOrder()
			}
		},
		getShowcase() {
			this.$root.loading = true
			axios.get(this.$root.url + '/api/get/showcase').then(response => {
				this.showcases = response.data;
				this.$root.loading = false
			});
		},
		create() {
			this.$root.loading = true
			axios.post(this.$root.url + '/admin/showcase/create', {
				name: this.form.name,
				order: this.showcases.length ? this.showcases.length + 1 : 1
			}).then(response => {
				this.form.name = null;
				this.showcases.push(response.data)
				this.$root.loading = false
				toastr.success('เพิ่มตู้แสดงสินค้าแล้ว');
			}, response => {
				this.$root.loading = false
				toastr.error('เกิดข้อผิดพลาด');

			});
		},
		remove(id, index) {
			if (!confirm('คุณแน่ใจหรือไม่ว่าจะลบ?')) {
				return;
			}
			this.$root.loading = true
			axios.delete(this.$root.url + '/admin/showcase/delete/' + id).then(response => {
				this.showcases.splice(index, 1)
				this.$root.loading = false
				toastr.success('ลบตู้แสดงสินค้าแล้ว')
			}, response => {
				toastr.error('เกิดข้อผิดพลาด')
			});
		},
		showToggle(id, index) {
			axios.put(this.$root.url + '/admin/showcase/show_toggle/' + id).then(response => {
				if (this.showcases[index].show) {
					this.$set(this.showcases[index], 'show', false)
				} else {
					this.$set(this.showcases[index], 'show', true)
				}
				toastr.success('บันทึกแล้ว');
			}, response => {
				toastr.error('เกิดข้อผิดพลาด');
			});
		},
		// order() {
		// 	this.showcases.map((showcase, index) => {
		// 		showcase.order = index + 1;
		// 	})
		// },
		saveOrder:	_.debounce(function() {
			axios.put(this.$root.url + '/admin/showcase/update_order', {
				showcases: this.showcases
			}).then(response => {
				toastr.success('บันทึกลำดับแล้ว')
			}, response => {
				toastr.error('เกิดข้อผิดพลาด')
			});
		}, 1500)
	},
	created() {
		this.getShowcase()
	}
}
</script>

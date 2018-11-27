<template>
<div>
  <div class="padding-15-bottom">
    <button @click.prevent="formVisible = !formVisible" class="btn blue form-submit">เพิ่มหมวดหมู่&nbsp;<i class="fas fa-plus"></i></button>
    <transition name="fade">
      <div v-show="formVisible" class="toggle-form margin-15-top">
        <form @submit.prevent="submit">
          <div class="form-group">
            <label class="full">ชื่อหมวดหมู่</label>
            <input required type="text" name="name" v-model="form.name">
          </div>
          <div class="form-group">
            <label class="full">มีหมวดหมู่ย่อยหรือไม่</label>
            <input class="radio" id="yes" type="radio" name="sub" v-model="form.hasSub" :value="true">
            <label class="radio" for="yes">มี</label>
            <input class="radio" id="no" type="radio" name="sub" v-model="form.hasSub" :value="false">
            <label class="radio" for="no">ไม่มี</label>
          </div>
          <div class="form-group" v-show="form.hasSub">
            <label class="full">ชื่อหมวดหมู่ย่อย</label>
            <input class="margin-10-right" type="text" name="name" v-model="subName">
            <button :disabled="!subName" type="button" class="btn blue" @click.prevent="addSub">เพิ่ม&nbsp;<small class="fas fa-plus"></small></button>
          </div>
          <div class="form-group" v-show="form.hasSub && form.sub.length">
            <p>หมวดหมู่ย่อย</p>
            <li class="number" v-for="sub in form.sub">{{ sub }}</li>
          </div>
          <div class="text-right padding-15-top">
            <button type="submit" class="btn green form-submit">ยืนยัน</button>
          </div>
        </form>
      </div>
    </transition>
  </div>
  <div v-if="categories.length">
    <h3>หมวดหมู่ของคุณ</h3>
    <div class="padding-10-v border-bottom-grey" v-for="(category, index) in categories">
      <div class="col-2-flex-res" v-show="editForm !== index">
        <div class="list">
          <h4>{{ index + 1 }}.&nbsp;{{ category.name }}</h4>
          <li class="dash" v-for="sub in category.subcategory">{{ sub.name }}</li>
        </div>
        <div class="text-right">
          <button @click.prevent="edit(index, category.id)" class="btn-flat blue margin-10-right" type="button">แก้ไข</button>
          <button @click.prevent="remove(index, category.id)" class="btn-flat red" type="button">ลบ</button>
        </div>
      </div>
      <transition name="fade">
        <div class="col-2-flex-res" v-show="editForm == index">
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
          <div class="text-right">
            <button type="button" class="btn green" @click.prevent="submitEdit(category)">บันทึก</button>
            <button type="button" class="btn red" @click.prevent="cancleEdit()">ยกเลิก</button>
          </div>
        </div>
      </transition>
    </div>
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
    this.categories = this.categoriesProp
  }
}
</script>

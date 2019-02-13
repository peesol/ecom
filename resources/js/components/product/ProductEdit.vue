<template>
  <div>
    <form v-on:submit.prevent="edit" enctype="multipart/form-data">
      <h2 class="page-title text-justify">แก้ไขสินค้า
      <back></back>
      </h2>
        <div class="grid-x grid-margin-x padding-10-top">
          <div class="cell medium-3">
            <p class="lead no-margin text-center">รูปตัวอย่าง</p>
            <div class="image-preview">
              <span class="fas fa-images"></span>
              <img :src="image_filename">
            </div>
          </div>
          <div class="cell medium-3 grid-y padding-15-v">
            <label class="btn primary margin-15-v text-center">
              <input class="hide" id="image-input" @change="previewThumbnail" type="file" :name="image_filename" accept="image/*">เลือกไฟล์&nbsp;+
            </label>
            <button class="btn primary margin-15-bottom" v-if="image_filename !== null" @click.prevent="removeFile">ลบ</button>
          </div>
          <div class="cell medium-6">
            <div class="form-group half-width-res">
              <label class="lead" for="name">ชื่อสินค้า</label>
              <input class="full-width"t v-validate="'required|min:6'" type="text" v-model="name" name="product_name">
              <span v-show="errors.has('product_name')" class="error">{{ errors.first('product_name') }}</span>
            </div>
            <div class="form-group half-width-res">
              <label class="lead" for="price">ราคา</label>
              <input class="full-width" v-validate="'required|numeric'" type="text" v-model="price" name="price">
              <span v-show="errors.has('price')" class="error">{{ errors.first('price') }}</span>
            </div>
            <div class="form-group half-width-res">
              <label class="lead" for="visibility">ใครดูได้</label>
              <select required class="select-input full-width" :name="visibility" v-model="visibility" @change="getSubCategory(category)">
                <option value="public">ทุกคน</option>
                <option value="unlisted">เฉพาะผู้ที่มีลิ้งค์</option>
              </select>
            </div>
          </div>
        </div>

      <div class="full-width">
        <div class="form-group">
          <label class="lead" for="description">คำอธิบายสินค้า</label>
          <textarea v-validate="'required'" class="description-input full-width" type="text" v-model="description" name="description"></textarea>
          <span v-show="errors.has('description')" class="error">{{ errors.first('description') }}</span>
        </div>
        <div class="grid-x align-right">
          <button :disabled="$root.loading || errors.any()" class="btn success medium-2 small-12" type="submit">บันทึก</button>
        </div>
      </div>
    </form>
    <hr>
    <dropzone :product-slug="uid"></dropzone>
    <hr>
    <product-choice :product-slug="uid"></product-choice>
  </div>
</template>

<script>
import Choice from './ProductChoice'
import Photos from './ProductPhoto'
export default {
  components: {
    'product-choice': Choice,
    'dropzone': Photos
  },
  data() {
    return {
      image_filename: null,
      name: null,
      price: null,
      description: null,
      visibility: null,
      uid: null,
      formVisible: false,
    }
  },
  methods: {
    getProduct() {
      axios.get(this.$root.url + '/api/get/products/' + this.$route.params.uid).then(response => {
        this.image_filename = this.$root.url + '/file/product/thumbnail/' + response.data.thumbnail
        this.name = response.data.name
        this.price = response.data.price
        this.description = response.data.description
        this.visibility = response.data.visibility
        this.uid = response.data.uid
      })
    },
    previewThumbnail(event) {
      var input = event.target;
      if (input.files && input.files[0]) {
        if (input.files[0].size > 2097152) {
          alert('ขนาดรูปต้องไม่เกินรูปละ 2 MB');
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
    edit() {
      toastr.options.preventDuplicates = true;
      toastr.options.timeOut = 2000;
      this.$root.loading = true
      if (document.getElementById("image-input").files.length == 0) {
        this.$Progress.start();
        toastr.info('โปรดรอ...')
        axios.put(this.$root.url + '/admin/product/' + this.$route.params.uid + '/update', {
          name: this.name,
          description: this.description,
          price: this.price,
          visibility: this.visibility,
        }).then(response => {
          this.$Progress.finish();
          this.$root.loading = false
          toastr.success('แก้ไขข้อมูลเรียบร้อยแล้ว')
        }, response => {
          this.$Progress.fail();
          this.$root.loading = false
          toastr.error('เกิดข้อผิดพลาด')
        });
      } else if (document.getElementById("image-input").files.length > 0) {
        this.$Progress.start();
        toastr.info('โปรดรอ...')
        axios.put(this.$root.url + '/admin/product/' + this.$route.params.uid + '/update', {
          name: this.name,
          description: this.description,
          price: this.price,
          thumbnail: this.image_filename,
          visibility: this.visibility,
        }).then(response => {
          this.$Progress.finish();
          this.$root.loading = false
          toastr.success('แก้ไขข้อมูลเรียบร้อยแล้ว')
        }, response => {
          this.$Progress.fail();
          this.$root.loading = false
          toastr.error('เกิดข้อผิดพลาด')
        });
      }
    }
  },
  created() {
    this.$root.loading = true
    this.getProduct()
    this.$root.loading = false
  }
}
</script>

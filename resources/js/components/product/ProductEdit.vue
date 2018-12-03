<template>
  <form v-on:submit.prevent="edit" enctype="multipart/form-data" class="padding-15-top full-width border-bottom-grey">
    <div class="col-2-flex-res">

      <div class="col-2-flex-res padding-10-right-screen">
        <div class="padding-15-bottom-mobile">
          <div class="image-preview margin-center">
            <span class="fas fa-images"></span>
            <img :src="image_filename">
          </div>
        </div>
        <div class="padding-15-bottom-mobile">
          <label class="file-input-btn full-width btn blue">
            <input id="image-input" @change="previewThumbnail" type="file" :name="image_filename" accept="image/*">
            เลือกไฟล์&nbsp;+
          </label>
          <button class="file-input-btn full-width btn teal" v-if="image_filename !== null" @click.prevent="removeFile">ลบ</button>
        </div>
      </div>

      <div class="half-width-res padding-10-left-screen">
        <div class="form-group half-width-res">
          <label class="full" for="name">ชื่อสินค้า</label>
          <input class="full-width"t v-validate="'required|min:6'" type="text" v-model="name" name="product_name">
          <span v-show="errors.has('product_name')" class="error">{{ errors.first('product_name') }}</span>
        </div>
        <div class="form-group half-width-res">
          <label class="full" for="price">ราคา</label>
          <input class="full-width" v-validate="'required|numeric'" type="text" v-model="price" name="price">
          <span v-show="errors.has('price')" class="error">{{ errors.first('price') }}</span>
        </div>
        <div class="form-group half-width-res">
          <label class="full" for="visibility">ใครดูได้</label>
          <select required class="select-input full-width" :name="visibility" v-model="visibility" @change="getSubCategory(category)">
            <option value="public">ทุกคน</option>
            <option value="unlisted">เฉพาะผู้ที่มีลิ้งค์</option>
          </select>
        </div>
      </div>
    </div>

    <div class="full-width">
      <div class="form-group">
        <label class="full" for="description">คำอธิบายสินค้า</label>
        <textarea v-validate="'required'" class="description-input full-width" type="text" v-model="description" name="description"></textarea>
        <span v-show="errors.has('description')" class="error">{{ errors.first('description') }}</span>
      </div>
      <div class="text-right full-width padding-15-bottom">
        <button :disabled="$root.loading || errors.any()" class="btn blue form-submit" type="submit">บันทึก</button>
      </div>
    </div>

  </form>
</template>

<script>
export default {
  data() {
    return {
      image_filename: this.imageSrc,
      name: this.productName,
      price: this.productPrice,
      description: this.productDescription,
      visibility: this.productVisibility,
      formVisible: false,
    }
  },
  props: {
    productSlug: null,
    productName: null,
    productPrice: null,
    productDescription: null,
    productVisibility: null,
    imageSrc: null,
  },

  methods: {
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
        axios.put(this.$root.url + '/admin/product/' + this.productSlug + '/update', {
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
        axios.put(this.$root.url + '/admin/product/' + this.productSlug + '/update', {
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
}
</script>

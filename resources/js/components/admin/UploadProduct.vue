<template>
  <form class="relative" v-on:submit.prevent="submit">
    <load-overlay bg="white-bg" :show="$root.loading"></load-overlay>
    <div class="padding-15-top">
      อัพโหลดได้ 6 รูป ขนาดรูปละไม่เกิน 2 mb
    </div>
    <div class="dropzone margin-15-v" id="image">
      <div class="dz-message" data-dz-message>
        <span>คลิกเพื่อเลือกรูปที่จะอัพโหลด</span>
      </div>
    </div>
    <div>
      <div class="form-group">
        <label class="full">ชื่อสินค้า</label>
        <input v-validate="'required|min:6'" type="text" class="form-input full-width" name="product_name" v-model="name">
        <span v-show="errors.has('product_name')" class="error">{{ errors.first('product_name') }}</span>
      </div>
      <div class="form-group half-width-res">
        <label class="full">ราคา</label>
        <input v-validate="'required|numeric'" type="text" class="form-input full-width" name="price" v-model="price">
        <span v-show="errors.has('price')" class="error">{{ errors.first('price') }}</span>
      </div>
      <div class="col-2-flex-res">
        <div class="form-group">
          <label class="full" for="category">หมวดหมู่</label>
          <select required class="full-width" v-model="category" @change.prevent="selectCategory(category)">
            <option v-for="category in categories" :value="category">{{category.name}}</option>
          </select>
          <span class="error" v-show="!categories.length">คุณไม่มีหมวดหมู่</span>
        </div>
        <transition name="fade">
          <div class="form-group" v-show="subcategories.length">
            <label class="full" for="subcategory">หมวดหมู่ย่อย</label>
            <select required class="full-width" v-model="subcategory">
              <option v-for="(subcategory, index) in subcategories" :value="subcategory">{{subcategory.name}}</option>
            </select>
          </div>
        </transition>
      </div>
    </div>
    <div class="form-group">
      <label class="full">คำอธิบายสินค้า</label>
      <textarea required v-validate="'required'" class="description-input full-width" name="description" v-model="description"></textarea>
      <span v-show="errors.has('description')" class="error">{{ errors.first('description') }}</span>
    </div>

      <div class="form-group">
        <label class="full">ตัวเลือกสินค้า (ไม่มีก็ได้)</label>
        <div class="padding-10-bottom">เช่น สี ไซส์ สามารถเพิ่มเท่าไหร่ก็ได้</div>
        <div class="flex">
          <input type="text" class="form-input margin-10-right" name="choices" v-model="choiceInput">
          <button :disabled="!choiceInput" type="button" class="btn blue" @click.prevent="addChoice()">เพิ่ม&nbsp;<small class="fas fa-plus"></small></button>
        </div>
        <div class="full-width padding-10-v" v-show="choices.length">
          <p>ตัวเลือกของสินค้านี้</p>
          <li class="number table-like" v-for="(choice, index) in choices">{{ choice }}&nbsp;<a class="float-right delete" @click.prevent="removeChoice(index)"><i class="fas fa-trash-alt font-large"></i></a></li>
        </div>
      </div>

    <div class="text-right full-width padding-15-top">
      <button :disabled="$root.loading || errors.any()" type="submit" id="submit-all" class="btn green form-submit">ยืนยัน</button>
    </div>
  </form>
</template>

<script>
import Dropzone from 'dropzone'
Dropzone.autoDiscover = false
export default {
  data() {
    return {
      categories: [],
      subcategories: [],
      choiceInput: null,
      category: null,
      subcategory: null,
      name: null,
      price: null,
      description: null,
      choices: []
    }
  },
  watch: {
    price: function (val) {
      return this.price = val.replace(/\W+/g, '');
    }
  },
  methods: {
    getCategory() {
      this.$root.loading = true
      this.$Progress.start()
      axios.get(this.$root.url + '/api/get/category').then(response => {
        this.categories = response.data
        this.$root.loading = false
        this.$Progress.finish()
      })
    },
    selectCategory(category) {
      this.subcategories = category.subcategory
      this.subcategory = []
    },
    addChoice() {
      this.choices.push(this.choiceInput)
      this.choiceInput = null
    },
    removeChoice(index) {
      if (confirm('คุณแน่ใจหรือไม่ว่าจะลบ?')) {
        this.choices.splice(index, 1)
      }
    },
    initDropzone: function() {
      self = this;
      self.$nextTick(function() {
        self.image = new Dropzone('#image', {
          method: 'post',
          url: self.$root.url + '/admin/product/create',
          autoProcessQueue: false,
          uploadMultiple: true,
          parallelUploads: 6,
          maxFiles: 6,
          maxFilesize: 2,
          acceptedFiles: '.jpg',
          addRemoveLinks: true,
          paramName: 'image',
          dictRemoveFile: '×',
          dictCancelUpload: '×',
          headers: {
            'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
          },
          init: function() {
            this.on('addedfile', function(file) {
              if (this.files.length > 6) {
                this.removeFile(this.files[0]);
              }
              if (file.size > 2097152) {
                alert('ขนาดรูปต้องไม่เกินรูปละ 2 MB');
                this.removeFile(file)
              }
            });
          },
          sendingmultiple: function(data, xhr, formData) {
            formData.append("name", self.name);
            formData.append("price", self.price);
            formData.append("description", self.description);
            formData.append("category_id", self.category.id);
            formData.append("subcategory_id", self.subcategory.id);
          },
          processing: function() {
            self.$Progress.start();
          },
          success: function() {
            toastr.success('อัพโหลดเรียบร้อย');
            this.removeFile(this.files[0]);
            self.$Progress.finish();
            document.location.href = self.$root.url + 'admin/product';
          },
          error: function() {
            self.$Progress.fail();
            toastr.error('เกิดข้อผิดพลาด');
            this.removeFile(this.files[0]);
          },
        });
      });
    },
    submit() {
      if (this.errors.any()) {
        alert('กรุณาแก้ไขข้อมูล')
      } else {
        self.image.processQueue();
      }

    }
  },
  created() {
    this.initDropzone()
    this.getCategory()
  },
}
</script>

<template>
  <form class="relative grid-container" v-on:submit.prevent="submit">
    <h2 class="page-title">
      เพิ่มสินค้า
      <back></back>
    </h2>
    <h3>รูปภาพสินค้า</h3>
    <div class="dropzone margin-15-v" id="image">
      <div class="dz-message" data-dz-message>
        <span>อัพโหลดได้ไม่เกิน 6 รูป ไม่เกิน รูปละ 1.5 MB</span><br>
        <span>คลิกเพื่อเลือกรูปที่จะอัพโหลด</span>
      </div>
    </div>
    <div class="grid-x grid-padding-x medium-up-2">
      <div class="cell form-group">
        <label class="full">ชื่อสินค้า</label>
        <input v-validate="'required'" type="text" class="form-input full-width" name="product_name" v-model="name">
        <span v-show="errors.has('product_name')" class="error">{{ errors.first('product_name') }}</span>
      </div>
      <div class="cell form-group">
        <label class="full">ราคา</label>
        <input v-validate="'required|numeric'" type="text" class="form-input full-width" name="price" v-model="price">
        <span v-show="errors.has('price')" class="error">{{ errors.first('price') }}</span>
      </div>
    </div>
    <div class="grid-x grid-padding-x medium-up-2">
      <div class="cell form-group">
        <label class="full" for="category">หมวดหมู่</label>
        <select required class="full-width" v-model="category" @change.prevent="selectCategory(category)">
          <option v-for="category in categories" :value="category">{{category.name}}</option>
        </select>
        <span class="error" v-show="!categories.length">คุณไม่มีหมวดหมู่</span>
      </div>
      <transition name="fade">
        <div class="cell form-group" v-show="subcategories.length">
          <label class="full" for="subcategory">หมวดหมู่ย่อย</label>
          <select required class="full-width" v-model="subcategory">
            <option v-for="(subcategory, index) in subcategories" :value="subcategory">{{subcategory.name}}</option>
          </select>
        </div>
      </transition>
    </div>

    <div class="form-group">
      <label class="full">คำอธิบายสินค้า</label>
      <textarea required v-validate="'required'" class="description-input full-width" name="description" v-model="description"></textarea>
      <span v-show="errors.has('description')" class="error">{{ errors.first('description') }}</span>
    </div>


      <div class="cell form-group">
        <label class="lead">ตัวเลือกสินค้า (ไม่มีก็ได้)</label>
        <div class="padding-10-bottom">เช่น สี ไซส์ สามารถเพิ่มเท่าไหร่ก็ได้</div>
        <div class="grid-x">
          <input type="text" class="form-input medium-3 no-margin small-8" name="choices" v-model="choiceInput">
          <button :disabled="!choiceInput" type="button" class="btn primary medium-1 small-4" @click.prevent="addChoice()">เพิ่ม&nbsp;<small class="fas fa-plus"></small></button>
        </div>
        <div class="full-width padding-10-v" v-show="choices.length">
          <p>ตัวเลือกของสินค้านี้</p>
          <li class="number table-like" v-for="(choice, index) in choices">{{ choice.name }}&nbsp;<a class="float-right delete" @click.prevent="removeChoice(index)"><i class="fas fa-trash-alt font-large"></i></a></li>
        </div>
      </div>

    <div class="align-right grid-x margin-15-top">
      <button :disabled="$root.loading || errors.any()" type="submit" id="submit-all" class="btn success small-12 medium-2">อัพโหลดสินค้า</button>
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
      this.choices.push({name: this.choiceInput})
      this.choiceInput = null
    },
    removeChoice(index) {
      this.choices.splice(index, 1)
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
            formData.append("choices", JSON.stringify(self.choices));
          },
          processing: function() {
            self.$Progress.start();
          },
          success: function() {
            toastr.success('อัพโหลดเรียบร้อย');
            this.removeFile(this.files[0]);
            self.$Progress.finish();
            document.location.href = self.$root.url + '/admin/product';
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

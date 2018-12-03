<template>
<div class="border-bottom-grey">
  <h2>รูปภาพสินค้า&nbsp;<small>ขนาด 500px*500px</small></h2>
  <div v-show="images.length" class="padding-15-v thumbnail-grid">
    <div v-for="(image, index) in images" class="thumbnail-wrapper fit">
      <img alt="currently uploading..." :src="image.filename">
      <button v-show="image.id && images.length > 1" @click.prevent="remove(image.id, index)" class="top-right btn red"><i class="fas fa-trash-alt"></i></button>
    </div>
  </div>

  <div class="padding-15-v">
    <button class="btn blue form-submit" @click.prevent="formVisible = !formVisible">
      อัพโหลดรูปสินค้า&nbsp;<i class="fas" :class="{'fa-angle-down' : !formVisible, 'fa-angle-up' : formVisible}"></i>
    </button>
  </div>

  <transition name="fade">
    <div v-show="formVisible" class="padding-15-bottom">
      <div class="dropzone" id="image">
        <div class="dz-message" data-dz-message>
          <span>อัพโหลดได้ไม่เกิน 6 รูป ไม่เกิน รูปละ 1.5 MB</span><br>
          <span>คลิกเพื่อเลือกรูปที่จะอัพโหลด</span>
        </div>
      </div>
      <div class="text-right padding-15-top">
        <button class="btn blue form-submit" @click.prevent="submit" id="photo-submit">อัพโหลด</button>
      </div>
    </div>
  </transition>
</div>
</template>

<script>
import Dropzone from 'dropzone'
Dropzone.autoDiscover = false
export default {
  data() {
    return {
      images: [],
      formVisible: false,
      dropzoneUrl: this.$root.url + '/admin/product/' + this.productSlug + '/upload_photo',
    }
  },
  props: ['productSlug'],

  methods: {
    getPhoto() {
      axios.get(this.$root.url + '/admin/product/' + this.productSlug + '/get_photo')
        .then(response => {
          this.images = response.data;
        });
    },

    remove(imageId, index) {
      if (!confirm('คุณแน่ใจหรือไม่ที่จะลบ?')) {
        return;
      }
      this.$Progress.start();
      axios.delete(this.$root.url + '/admin/product/delete_photo/' + imageId).then(response => {
        this.images.splice(index, 1)
        this.$Progress.finish()
        toastr.success('ลบรูปภาพแล้ว')
      }, response => {
        toastr.error('เกิดข้อผิดพลาด')
      });
    },

    initDropzone: function() {
      self = this;
      self.$nextTick(function() {
        self.image = new Dropzone("#image", {
          method: 'post',
          url: self.dropzoneUrl,
          autoProcessQueue: false,
          uploadMultiple: true,
          parallelUploads: 7,
          maxFiles: 7,
          maxFilesize: 2,
          acceptedFiles: '.jpg',
          addRemoveLinks: true,
          paramName: "image",
          dictRemoveFile: "&times;",
          dictCancelUpload: "&times;",
          headers: {
            'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
          },
          init: function() {
            this.on('addedfile', function(file) {
              if (this.files.length + self.images.length > 7 || this.files.length > 7) {
                this.removeFile(this.files[0])
              }
              if (file.size > 2097152) {
                alert('ขนาดรูปต้องไม่เกินรูปละ 2 MB');
                this.removeFile(file)
              }
            });
          },
          processing: function() {
            self.$Progress.start();
          },
          success: function(file, response) {
            self.images.push({
              id: null,
              filename: file.dataURL
            })
            toastr.success('อัพโหลดเรียบร้อย')
            this.removeFile(this.files[0])
            self.$Progress.finish()
          },
          error: function() {
            self.$Progress.fail();
            toastr.error('เกิดข้อผิดพลาด')
            this.removeFile(this.files[0]);
          },

        });
      });
    },
    submit() {
      self.image.processQueue();
    }
  },
  created() {
    this.getPhoto();
    this.initDropzone();
  }
}
</script>

<template>
<div>
  <div class="grid-x align-justify">
    <h3 class="cell medium-6 no-margin">รูปภาพสินค้า&nbsp;<small>ขนาด 500px*500px</small></h3>
    <div class="cell align-right medium-2">
      <button class="cell btn primary" @click.prevent="formVisible = !formVisible">
        อัพโหลดรูปสินค้า&nbsp;<i class="fas" :class="{'fa-angle-down' : !formVisible, 'fa-angle-up' : formVisible}"></i>
      </button>
    </div>
  </div>

  <transition name="fade">
    <div class="margin-15-top" v-show="formVisible">
      <div class="dropzone" id="image">
        <div class="dz-message" data-dz-message>
          <span>อัพโหลดได้ไม่เกิน 6 รูป ไม่เกิน รูปละ 1.5 MB</span><br>
          <span>คลิกเพื่อเลือกรูปที่จะอัพโหลด</span>
        </div>
      </div>
      <div class="grid-x align-right padding-15-top">
        <button class="cell btn success medium-2" @click.prevent="submit" id="photo-submit">อัพโหลด</button>
      </div>
      <hr>
    </div>
  </transition>

  <div v-if="images.length" class="padding-15-v thumbnail-grid">
    <div v-for="(image, index) in images" class="image-preview">
      <img alt="currently uploading..." :src="image.filename">
      <button v-show="image.id && images.length > 1" @click.prevent="remove(image.id, index)" class="top-right btn error"><i class="fas fa-trash-alt"></i></button>
    </div>
  </div>
  <div v-else>
    <p class="lead margin-15 text-center">สินค้านี้ไม่มีรูปภาพ</p>
  </div>
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
      dropzoneUrl: this.$root.url + '/admin/product/' + this.$route.params.uid + '/upload_photo',
    }
  },
  props: ['productSlug'],

  methods: {
    getPhoto() {
      axios.get(this.$root.url + '/admin/product/' + this.$route.params.uid + '/get_photo')
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

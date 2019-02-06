<template>
<slick ref="slick" :options="slickOptions">
  <a v-for="img in imgs">
    <img class="product-slick-img" :src="imgUrl + img.filename" alt="">
  </a>
</slick>
</template>

<script>
import Slick from 'vue-slick';

export default {
  components: { Slick },

  data() {
    return {
      slickOptions: {
          slidesToShow: 1,
          dots: true
      },
      imgUrl: this.$root.url + '/file/product/photo/',
    }
  },

  props: ['imgs']
}
</script>

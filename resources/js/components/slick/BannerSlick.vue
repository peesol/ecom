<template>
<div class="home-banner">
  <slick ref="slick" :options="slickOptions">
    <a v-for="banner in banners">
      <img :src="banner" alt="">
    </a>
  </slick>
</div>
</template>

<script>
import Slick from 'vue-slick';

export default {
  components: { Slick },

  data() {
    return {
      slickOptions: {
          slidesToShow: 1,
          dots: this.enableDots
      }
    }
  },

  props: ['banners', 'enableDots']
}
</script>

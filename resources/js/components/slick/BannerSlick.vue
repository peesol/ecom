<template>
<div class="home-banner">
  <slick ref="slick" :options="slickOptions">
    <a :href="banner.link" v-for="banner in banners">
      <img :src="bannerUrl + banner.type + '/' +  banner.filename" alt="banner">
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
      },
      bannerUrl: this.$root.url + '/file/banner/'
    }
  },

  props: ['banners', 'enableDots']
}
</script>

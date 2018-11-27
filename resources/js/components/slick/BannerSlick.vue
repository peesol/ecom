<template>
<div>
  <slick ref="slick" :options="slickOptions">
  <a><img :src="banners" alt="" style="width:100%"></a>
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
          dots: true
      }
    }
  },

  props: ['banners']
}
</script>

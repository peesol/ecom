<template>
<div class="product-slick">
  <slick ref="slick" :options="slickOptions">
    <div class="thumbnail-wrapper product" v-for="item in products">
      <div class="thumbnail-img-wrapper">
        <img :src="imgUrl + item.thumbnail" :alt="item.thumbnail">
      </div>
      <div class="details">
        <a class="title">{{ item.name }}</a>
        <p class="price" v-if="!item.discount_price">{{ $number.currency(item.price) }}&nbsp;THB</p>
        <p class="price" v-else>
          <s>{{ $number.currency(item.price) }}</s>
          {{ $number.currency(item.discount_price) }}&nbsp;THB
        </p>
      </div>
    </div>
  </slick>
</div>
</template>

<script>
import Slick from 'vue-slick';
import { options } from './slick-options';

export default {
  components: { Slick },

  data() {
    return {
      slickOptions: options({view: 'shop'}),
      imgUrl: this.$root.url + '/file/product/thumbnail/',
    }
  },

  props: ['products']
}
</script>

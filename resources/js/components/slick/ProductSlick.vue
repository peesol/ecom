<template>
<div class="product-slick">
  <slick ref="slick" :options="slickOptions">

    <div class="card product" v-for="(item, index) in productsData">
      <div class="card-section">
        <a :href="$root.url + '/product/' + item.uid">
          <img src="http://home.bt.com/images/the-20-best-views-in-the-uk-revealed-136417214455702601-170411144310.jpg" :alt="item.thumbnail">
        </a>
        <span class="top-right sale" v-show="item.discount_price">-&nbsp;{{ saleCalc(item.price, item.discount_price) }}%</span>
      </div>
      <div class="details card-section">
        <a class="title" :href="$root.url + '/product/' + item.uid">{{ item.name }}</a>
        <p class="price" v-if="!item.discount_price">{{ $number.currency(item.price) }}&nbsp;THB</p>
        <p class="price sale" v-else>
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
      productsData: this.products,
      slickOptions: options({view: 'shop'}),
      imgUrl: this.$root.url + '/file/product/thumbnail/',
    }
  },
  props: ['products'],
  methods: {
    saleCalc(price, discount) {
      var val = (price - discount) / ((price + discount) / 2)
      var result = val * 100
      return  Math.round(result);
    }
  },
  created() {
    this.saleCalc()
  }
}
</script>

<template>
  <transition name="fade">
    <div v-show="$root.showModal" class="modal-backdrop">
      <div class="modal relative" :class="size">
        <load-overlay bg="white-bg" :show="$root.loading" padding="0"></load-overlay>
        <slot name="heading"></slot>
        <slot name="body"></slot>
        <slot name="footer"></slot>
      </div>
    </div>
  </transition>
</template>

<script>
  export default {
    name: 'modal',
    methods: {
      close() {
        this.$emit('close')
      },
    },
    props: ['size'],
    watch: {
      '$root.showModal' : {
        handler() {
          if (this.$root.showModal) {
            document.body.classList.add("modal-open");
          } else {
            document.body.classList.remove("modal-open");
          }
        }
      }
    }
  };
</script>

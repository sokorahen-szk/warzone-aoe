<template>
  <img
    :class="['img', {thumbnail: thumbnail}]"
    :style="addStyle"
    :src="src"
    :alt="alt"
  />
</template>

<style scoped>
.thumbnail {
  margin: 0;
  padding: 14px;
  vertical-align: top;
  object-fit: contain;
  width: 100%;
}
</style>

<script>
import {addStyleParser} from '@/services/helper'
export default {
  name: 'Img',
  props: {
    src: {type: String, required: false, default: null},
    alt: {type: String, default: ''},
    styles: {type: Object, required: false, default: null},
    thumbnail: {type: Boolean, default: false},
  },
  data() {
    return {
      //
    }
  },
  computed: {
    addStyle() {
      return addStyleParser(this.styles)
    }
  }
}
</script>
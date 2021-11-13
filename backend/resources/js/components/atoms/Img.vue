<template>
  <img
    :class="['img', {thumbnail: thumbnail}]"
    :src="src"
    :alt="alt"
    :width="width"
    :height="height"
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
    width: {type: [String, Number], default: '100%'},
    height: {type: [String, Number], default: 'auto'},
    thumbnail: {type: Boolean, default: false},
  },
  data() {
    return {
      //
    }
  },
}
</script>
<template>
  <img
    :src="src"
    :alt="alt"
    :width="width"
    :height="height"
  />
</template>

<style scoped>
img {
  object-fit: contain;
}
</style>

<script>
export default {
  name: 'Img',
  props: {
    src: {type: String, required: false, default: null},
    alt: {type: String, default: ''},
    width: {type: [String, Number], default: '100%'},
    height: {type: [String, Number], default: 'auto'},
  },
  data() {
    return {
      //
    }
  },
}
</script>
<template>
  <img class="img" :src="src" :alt="alt" />
</template>

<style scoped>
.img {
  margin: 0;
  padding: 0;
  vertical-align: top;
}
</style>

<script>
export default {
  name: 'Img',
  props: {
    src: {type: String, required: true},
    alt: {type: String, default: ''},
  },
  data() {
    return {
      //
    }
  }
}
</script>
<template>
  <v-avatar
    :color="color"
    :size="size"
  >
  <Img v-if="src" :src="src" :alt="alt" />
  </v-avatar>
</template>

<script>
import Img from '@atoms/Img'
export default {
  name: 'Avatar',
  props: {
    color: {type: String, default: 'grey darken-1'},
    size: {type: Number},
    src: {type: String, default: null},
    alt: {type: String, default: ''},
  },
  components: {
    Img
  }
}
</script>

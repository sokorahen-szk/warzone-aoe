<template>
  <v-overlay :value="show">
    <slot></slot>
  </v-overlay>
</template>

<script>
export default {
  name: 'Overlay',
  props: {
    enabled: {type: Boolean, default: false},
  },
  data() {
    return {
      show: this.enabled,
    }
  }
}
</script>

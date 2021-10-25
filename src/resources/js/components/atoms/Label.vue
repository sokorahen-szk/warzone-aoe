<template>
  <v-chip
    class="ma-2"
    :color="color"
    label
  >
    <v-icon
      left
      size="14"
      v-if="tag"
    >
      mdi-label
    </v-icon>
    <slot></slot>
  </v-chip>
</template>

<script>
export default {
  name: 'Label',
  props: {
    tag: { type: Boolean, default: false},
    color: { type: String, default: ''},
  },
  data() {
    return {
      //
    }
  }
}
</script>

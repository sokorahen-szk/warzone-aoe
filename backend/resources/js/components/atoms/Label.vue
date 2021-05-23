<template>
  <v-chip
    class="ma-2"
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
  },
  data() {
    return {
      //
    }
  }
}
</script>

<template>
  <v-btn
    :block="block"
    :depressed="depressed"
    @click="clickButton"
    :color="color"
  >
    {{label}}
  </v-btn>
</template>

<script>
export default {
  name: 'Button',
  props: {
    label: {type: String},
    block: {type: Boolean, default: false},
    path: {type: String},
    depressed: {type: Boolean, default: false},
    color: {type: String, default: ''},
  },
  data() {
    return {
      //
    }
  },
  methods: {
    clickButton() {
      return this.$emit('click')
    }
  }
}
</script>

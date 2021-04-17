<template>
  <v-btn
    :block="block"
    :depressed="depressed"
    @click="clickButton"
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

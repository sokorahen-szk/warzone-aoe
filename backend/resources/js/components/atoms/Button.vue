<template>
  <v-btn
    :block="block"
    :depressed="depressed"
    @click="clickButton"
    :color="color"
    :disabled="disabled"
    :text="text"
    :width="width"
    :height="height"
    :tile="tile"
  >
    <v-icon
      v-if="icon"
      dark
      left
    >
      {{iconType}}
    </v-icon>{{label}}
  </v-btn>
</template>

<script>
import router from '@/router/index'
export default {
  name: 'Button',
  props: {
    label: {type: String},
    block: {type: Boolean, default: false},
    path: {type: String, default: null},
    depressed: {type: Boolean, default: false},
    color: {type: String, default: ''},
    disabled: {type: Boolean, default: false},
    text: {type: Boolean, default: false},
    icon: {type: Boolean, default: false},
    tile: {type: Boolean, default: false},
    iconType: {type: String, default: 'mdi-checkbox-marked-circle'},
    width: {type: [String, Number]},
    height: {type: [String, Number]},
  },
  data() {
    return {
      //
    }
  },
  methods: {
    clickButton() {
      // https://www.softel.co.jp/blogs/tech/archives/6628
      if (this.path) {
        router.push({path: this.path}).catch(err => {})
      }
      return this.$emit('click')
    }
  }
}
</script>

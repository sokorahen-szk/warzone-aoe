<template>
  <span :class="setColor">{{value}}</span>
</template>

<script>
export default {
  name: 'TextMark',
  props: {
    value: {type: String, default: null},
    color: {Type: String, default: ''},
  },
  computed: {
    setColor() {
      return `${this.color}--text`
    }
  },
  data() {
    return {
      //
    }
  }
}
</script>
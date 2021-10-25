<template>
  <v-chip
    text-color="white"
    :color="setStatus ? 'green': 'red'"
  >
  {{setStatus ? '有効' : '無効'}}
  </v-chip>
</template>

<script>
export default {
  name: 'Status',
  props: {
    label: {type: String},
    value: {type: [Number, Boolean]},
  },
  computed: {
    setStatus() {
      return Boolean(this.value)
    }
  },
  data() {
    return {

    }
  }
}
</script>
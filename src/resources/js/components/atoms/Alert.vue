<template>
<v-alert
  v-show="show"
  dismissible
  :type="type"
  :dense="dense"
  @input="closed"
>{{ message }}</v-alert>
</template>

<style scoped>

</style>

<script>
export default {
  name: 'Alert',
  props: {
    properties: {type: [Object, Array], default: {}},
    dense: {type: Boolean, default: false},
  },
  watch: {
    properties: {
      handler(newValue, oldValue) {
        this.$set(this, 'show', newValue.show)
        this.$set(this, 'type', newValue.type)
        this.$set(this, 'message', newValue.message)
      },
      deep: true
    },
  },
  methods: {
    closed() {
      this.$set(this, 'show', false)
    }
  },
  data() {
    return {
      show: false,
      type: 'info',
      message: null,
    }
  }
}
</script>
<template>
<v-alert
  v-show="show"
  dismissible
  :type="type"
  :dense="dense"
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
      handler(value) {
        this.$set(this, 'show', value.show)
        this.$set(this, 'type', value.type)
        this.$set(this, 'message', value.message)

        setInterval(() => {
          this.$set(this, 'show', false)
        }, 10000)
      },
      deep: true
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
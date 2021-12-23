<template>
    <div>{{timer}}</div>
</template>

<script>
export default {
  name: 'Timer',
  props: {
    lDatetime: {type: String},
    rDatetime: {type: String},
  },

  data() {
    return {
    }
  },
  computed: {
      timer() {
            const diff = this.$dayjs(this.rDatetime).diff(this.lDatetime)
            return diff / 1000
      }
  }
}
</script>
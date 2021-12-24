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
            let time = this.$dayjs(this.rDatetime).diff(this.lDatetime) / 1000
            if (time >= (3600 * 24)) {
                return `${this.toDays(time)}日`
            }
            if (time >= 3600) {
                return `${this.toHours(time)}時間${this.toMinutes(time)}分`
            }
            if (time >= 60) {
                 return `${this.toMinutes(time)}分${this.toSeconds(time)}秒`
            }

            return `${this.toSeconds(time)}秒`
      }
  },
  methods: {
      toDays(time) {
          return Math.floor(time / (3600 * 24))
      },
      toHours(time) {
          return Math.floor(time / 3600)
      },
      toMinutes(time) {
          return Math.floor(time / 60) % 60
      },
      toSeconds(time) {
          return time % 60
      }
  }
}
</script>
<template>
  <vue-c3
    :handler="handler"
  />
</template>

<script>
import Vue from 'vue'
import VueC3 from 'vue-c3'
import 'c3/c3.min.css'

export default {
  name: 'Chart',
  components: {
    VueC3,
  },
  data () {
    return {
      handler: new Vue()
    }
  },
  mounted () {
    const options = {
      data: {
        x: 'date',
        columns: [
          ['date','2020-10-01','2020-10-02','2020-10-03','2020-10-04','2020-10-05'],
          ['レーティング', 2, 4, 1, 5, 2, 1],
        ],
      },
      axis: {
        x: {
          type: 'timeseries',
          tick: {
            format: '%Y-%m-%d'
          }
        },
      },
    }

    this.handler.$emit('init', options)
  },
}
</script>

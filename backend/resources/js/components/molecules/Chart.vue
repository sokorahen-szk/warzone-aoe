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
  props: {
    columns: {type: Object },
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
        columns: [],
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

    options.data.columns = [this.columns.date, this.columns.raiting];

    this.handler.$emit('init', options)
  },
}
</script>

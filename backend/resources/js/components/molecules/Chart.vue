<template>
  <div>
    <template v-if="show">
      <vue-c3
        :handler="handlerData"
      />
    </template>
    <template v-else>
      <Loading size="64" />
    </template>
  </div>
</template>

<script>
import Vue from 'vue'
import VueC3 from 'vue-c3'
import 'c3/c3.min.css'
import Loading from '@/components/atoms/Loading'

export default {
  name: 'Chart',
  components: {
    VueC3,
    Loading,
  },
  props: {
    columns: {type: Object },
    numberLabel: {type: Boolean, default: false},
  },
  data () {
    return {
      handlerData: new Vue(),
      show: true,
    }
  },
  watch: {
    columns: {
      handler(v) {
        this.setOptions(v)
      },
      deep: true,
    },
  },
  methods: {
    setOptions(v = null) {
      const data = v || this.columns
      const options = {
        data: {
          x: 'date',
          xs: {
              date: ['rating', 'mu'],
          },
          types: {
              rating: 'area',
          },
          columns: [
            ['date'],
            ['rating'],
            ['mu'],
          ],
          labels: this.numberLabel,
        },
        axis: {
          x: {
            type: 'timeseries',
            tick: {
              format: '%m月%d日',
              rotate: 90,
            }
          },
        },
        zoom: {
            enabled: true
        }
      }

      options.data.columns = [
        data.dateList,
        data.rateList,
        data.muList,
      ];

      this.handlerData.$emit('init', options)
    }
  }
}
</script>

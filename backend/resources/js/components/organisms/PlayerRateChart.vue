<template>
  <div>
    <Chart
      :columns="columns"
    />
    <v-row>
      <v-col cols="8">
        <ChartFilter
          @change="chartFilter = $event"
          :selectedDefault="chartFilter"
        />
      </v-col>
      <v-col cols="4" class="text-right">
         <Button
          :label="zoom ? '縮小' : '拡大'"
          text
          @click="zoom = !zoom"
        />
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col cols="12" sm="6" md="6" lg="6">
        <CalendarInput
          label="抽出開始"
          :disabled="chartFilter !== 0"
          @update="beginDate = $event"
        />
      </v-col>
      <v-col cols="12" sm="6" md="6" lg="6">
        <CalendarInput
          label="抽出終了"
          :disabled="chartFilter !== 0"
          @update="endDate = $event"
        />
      </v-col>
    </v-row>
  </div>
</template>

<script>
import Chart from '@/components/molecules/Chart'
import ChartFilter from '@/components/molecules/ChartFilter'
import CalendarInput from '@/components/molecules/CalendarInput'
import Button from '@/components/atoms/Button'

export default {
  name: 'PlayerRateChart',
  components: {
    Chart,
    ChartFilter,
    CalendarInput,
    Button,
  },
  props: {
    columns: { type: Object },
  },
  watch: {
    chartFilter() { this.filters() },
    beginDate() { this.filters() },
    endDate() { this.filters() },
    zoom() { this.filters() },
  },
  data () {
    return {
      chartFilter: 1,
      beginDate: null,
      endDate: null,
      zoom: false,
    }
  },
  methods: {
    filters() {
      return this.$emit('filters', {
        option: this.chartFilter,
        date: {
          begin_date: this.beginDate,
          end_date: this.endDate,
        },
        zoom: this.zoom,
      })
    }
  }
}
</script>

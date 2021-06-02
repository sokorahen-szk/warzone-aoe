<template>
  <div>
    <Chart
      :columns="columns"
      :show="loading"
    />
    <ChartFilter
      @change="chartFilter = $event"
      :selectedDefault="chartFilter"
    />
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

export default {
  name: 'PlayerRateChart',
  components: {
    Chart,
    ChartFilter,
    CalendarInput,
  },
  props: {
    columns: { type: Object },
  },
  data () {
    return {
      chartFilter: 1,
      beginDate: null,
      endDate: null,
      loading: false,
    }
  },
}
</script>

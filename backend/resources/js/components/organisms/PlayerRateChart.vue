<template>
  <div>
    <Chart />
    <ChartFilter />
    <v-row no-gutters>
      <v-col cols="12" sm="6" md="6" lg="6">
        <CalendarInput label="抽出開始" />
      </v-col>
      <v-col cols="12" sm="6" md="6" lg="6">
        <CalendarInput label="抽出終了" />
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
  data () {
    return {
      //
    }
  },
}
</script>

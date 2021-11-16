<template>
  <v-container>
    <PlayerRateChart
      :columns="columns"
      @filters="updateFilter"
    />
  </v-container>
</template>

<script>
import PlayerRateChart from '@organisms/PlayerRateChart'
import { mapActions } from 'vuex'
import { filterScopeDateFilter } from '@/services/api_helper'

export default {
  name: 'IndexRatePlayerHisyory',
  components: {
    PlayerRateChart,
  },
  props: {
    id: {type: [Number, String]}
  },
  data() {
    return {
      columns: {
        dateList: [],
        rateList: [],
      },

      isLoading: false,
    }
  },
  methods: {
    ...mapActions('playerStore', ['playerRaitingList']),
    updateFilter(filter) {
      let params = filterScopeDateFilter(filter, this.$dayjs())
      this.fetchPlayerRaitingList(params);
    },
    toColumns(raiting) {
      let dateList = ["date"]
      let rateList = ["rating"]

      raiting.forEach( (item) => {
        dateList.push(item.startedAt)
        rateList.push(item.rate)
      })
      this.columns.dateList = Object.assign([], dateList)
      this.columns.rateList = Object.assign([], rateList)
    },
    fetchPlayerRaitingList(options) {
      this.isLoading = true

      new Promise((resolve) => {
        resolve(this.playerRaitingList({id: this.id, options: options}))
      })
      .then( (res) => {
        this.toColumns(res)
      })
      .catch(err => {
        alert(err)
      })
      .finally(() => {
        this.isLoading = false
      })
    },
  },
  mounted() {
    this.fetchPlayerRaitingList({
      begin_date: this.$dayjs().startOf('month').format('YYYY-MM-DD')
    });
  }
}
</script>
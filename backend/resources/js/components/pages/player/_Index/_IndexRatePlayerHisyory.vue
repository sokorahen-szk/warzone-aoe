<template>
  <div>
    <PlayerRateChart
      :columns="columns"
      @filters="updateFilter"
    />
  </div>
</template>

<script>
import PlayerRateChart from '@/components/organisms/PlayerRateChart'
import { mapGetters, mapActions } from 'vuex'
import {filterScopeDateFilter} from '@/services/api_helper'

export default {
  name: 'IndexRatePlayerHisyory',
  components: {
    PlayerRateChart
  },
  data() {
    return {
      columns: {
        dateList: [],
        rateList: [],
        rankList: [],
      },
    }
  },
  methods: {
    ...mapActions('accountStore', ['raiting']),
    ...mapGetters('accountStore', ['getRaiting']),
    updateFilter(filter) {
      let params = filterScopeDateFilter(filter, this.$dayjs)
      this.raiting(params);
    }
  },
  mounted() {
    this.raiting({begin_date: this.$dayjs.format('YYYY-MM-DD')});

    this.$store.subscribe((mutation) => {
      if (mutation.type === 'accountStore/setRaiting') {
        this.$nextTick( () => {
          const raiting = this.getRaiting()

          let dateList = ["date"]
          let muList = ["mu"]

          raiting.forEach( (item) => {
            dateList.push(item.startedAt)
            muList.push(item.mu)
          })
          this.columns.dateList = Object.assign([], dateList)
          this.columns.muList = Object.assign([], muList)
        })
      }
    })
  }
}
</script>
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
      let params = {}
      let date = this.$dayjs

      switch(filter.option) {
        case 0:
          params = Object.assign(params, filter.date)
          break
        case 1:
          params = {begin_date: date.startOf('month').format('YYYY-MM-DD')}
          break
        case 2:
          params = {
            begin_date: date.subtract(1, 'month').startOf('month').format('YYYY-MM-DD'),
            end_date: date.subtract(1, 'month').endOf('month').format('YYYY-MM-DD'),
          }
          break
        case 3:
          params = {
            begin_date: date.startOf('year').format('YYYY-MM-DD'),
            end_date: date.endOf('year').format('YYYY-MM-DD')
          }
          break
        case 4:
          params = {
            begin_date: date.subtract(1, 'year').startOf('year').format('YYYY-MM-DD'),
            end_date: date.subtract(1, 'year').endOf('year').format('YYYY-MM-DD')
          }
          break
      }

      this.zoom = filter.zoom
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
<template>
  <v-container>
    <PlayerRateChart
      :columns="columns"
      @filters="updateFilter"
    />
  </v-container>
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
  props: {
    id: {type: [Number, String]}
  },
  data() {
    return {
      columns: {
        dateList: [],
        rateList: [],
      },
    }
  },
  methods: {
    ...mapActions('playerStore', ['playerRaitingList']),
    ...mapGetters('playerStore', ['getPlayerRaitings']),
    updateFilter(filter) {
      let params = filterScopeDateFilter(filter, this.$dayjs())
      this.playerRaitingList({id: this.id, options: params});
    }
  },
  mounted() {
    this.playerRaitingList({id: this.id, options: {begin_date: this.$dayjs().format('YYYY-MM-DD')}});

    this.$store.subscribe((mutation) => {
      if (mutation.type === 'playerStore/setPlayerRaitings') {
        this.$nextTick( () => {
          const raiting = this.getPlayerRaitings()

          let dateList = ["date"]
          let rateList = ["rating"]

          raiting.forEach( (item) => {
            dateList.push(item.startedAt)
            rateList.push(item.rate)
          })
          this.columns.dateList = Object.assign([], dateList)
          this.columns.rateList = Object.assign([], rateList)
        })
      }
    })
  }
}
</script>
<template>
  <CommonWithRightColumnTemplate
    outlined
    :device="getDeviceType"
    :zoom="zoom"
  >
    <template slot="right">
      <AccountRightMenu />
    </template>
    <template slot="container">
      <v-container>
        <PlayerRateChart
          :columns="columns"
          @filters="updateFilter"
        />
      </v-container>
    </template>
  </CommonWithRightColumnTemplate>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import CommonWithRightColumnTemplate from '@/components/templates/CommonWithRightColumnTemplate'
import AccountRightMenu from '@/components/organisms/AccountRightMenu'
import PlayerRateChart from '@/components/organisms/PlayerRateChart'
import {filterScopeDateFilter} from '@/services/api_helper'

export default {
  name: 'AccountRating',
  components: {
    CommonWithRightColumnTemplate,
    AccountRightMenu,
    PlayerRateChart
  },
  data() {
    return {
      columns: {
        dateList: [],
        rateList: [],
        rankList: [],
      },
      zoom: false,
    }
  },
  computed: {
    ...mapGetters('breakpointStore', ['getDeviceType']),
  },
  methods: {
    ...mapActions('accountStore', ['raiting']),
    ...mapGetters('accountStore', ['getRaiting']),
    updateFilter(filter) {
      let params = filterScopeDateFilter(filter, this.$dayjs())
      this.zoom = filter.zoom
      this.raiting(params);
    }
  },
  mounted() {
    this.raiting({begin_date: this.$dayjs().format('YYYY-MM-DD')});

    this.$store.subscribe((mutation) => {
      if (mutation.type === 'accountStore/setRaiting') {
        this.$nextTick( () => {
          const raiting = this.getRaiting()

          let dateList = ["date"]
          let rateList = ["rating"]
          let muList = ["mu"]

          raiting.forEach( (item) => {
            dateList.push(item.startedAt)
            rateList.push(item.rate)
            muList.push(item.mu)
          })
          this.columns.dateList = Object.assign([], dateList)
          this.columns.rateList = Object.assign([], rateList)
          this.columns.muList = Object.assign([], muList)
        })
      }
    })
  }
}
</script>
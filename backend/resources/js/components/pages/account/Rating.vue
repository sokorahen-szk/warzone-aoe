<template>
  <CommonWithRightColumnTemplate
    outlined
    :device="getDeviceType"
    :zoom="zoom"
  >
    <template slot="right">
      <AccountRightMenu :role="profileView.role" />
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
import CommonWithRightColumnTemplate from '@templates/CommonWithRightColumnTemplate'
import AccountRightMenu from '@organisms/AccountRightMenu'
import PlayerRateChart from '@organisms/PlayerRateChart'
import {filterScopeDateFilter} from '@/services/api_helper'
import { profileViewTemplate } from '@/config/account'
import { objCopy } from '@/services/helper'

export default {
  name: 'AccountRating',
  components: {
    CommonWithRightColumnTemplate,
    AccountRightMenu,
    PlayerRateChart
  },
  data() {
    return {
      profileView: profileViewTemplate,
      columns: {
        dateList: [],
        rateList: [],
        rankList: [],
      },
      zoom: false,
    }
  },
  computed: {
    ...mapGetters('accountStore', ['getProfile']),
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
    this.raiting({begin_date: this.$dayjs().startOf('month').format('YYYY-MM-DD')})

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

    this.$store.subscribe((mutation) => {
      if (mutation.type === 'accountStore/setProfile') {
        this.$set(this, 'profileView', objCopy(this.profileView, this.getProfile))
      }
    })
    this.$set(this, 'profileView', objCopy(this.profileView, this.getProfile))
  }
}
</script>
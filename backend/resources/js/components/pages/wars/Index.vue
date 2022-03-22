<template>
  <CommonOneColumnTemplate :device="deviceType">
    <template slot="container">
      <Loading v-if="isLoading" size="64" class="pt-4" />
      <div v-else>
        <GameRecordTablePc
          v-if="deviceType == 'pc'"
          :gameRecordList="gameRecordList"
          :gameRecordTotalPage="gameRecordTotalPage"
          :currentPage="currentPage"
          :deviceType="deviceType"
          @changePage="changePage"
        />
        <GameRecordTableSp
          v-else
          :gameRecordList="gameRecordList"
          :gameRecordTotalPage="gameRecordTotalPage"
          :currentPage="currentPage"
          :deviceType="deviceType"
          @changePage="changePage"
        />
      </div>
    </template>
  </CommonOneColumnTemplate>
</template>

<script>
import CommonOneColumnTemplate from '@templates/CommonOneColumnTemplate'
import GameRecordTablePc from '@organisms/pc/GameRecordTable'
import GameRecordTableSp from '@organisms/sp/GameRecordTable'
import Loading from '@atoms/Loading'
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'Index',
  components: {
    CommonOneColumnTemplate,
    GameRecordTablePc,
    GameRecordTableSp,
    Loading,
  },
  data() {
    return {
      isLoading: false,
      currentPage: 1,
      gameRecordList: []
    }
  },
  computed: {
    ...mapGetters({
      deviceType: 'breakpointStore/getDeviceType',
      gameRecordTotalPage: 'warStore/getAllTotalPage',
    }),
  },
  methods: {
    ...mapActions({
      fetchWarHistoryListToStore: 'warStore/fetchAllWarHistoryList'
    }),
    fetchWarHistoryList(page) {
      this.isLoading = true
      new Promise((resolve) => {
        resolve(this.fetchWarHistoryListToStore({page: page}))
      })
      .then(res => {
        this.setGameRecordList(page)
      })
      .finally(() => {
        this.isLoading = false
      })
    },
    changePage(val) {
      this.currentPage = val
      this.fetchWarHistoryList(this.currentPage)
    },
    setGameRecordList(page) {
      if(!page){
        return
      }
      this.gameRecordList = this.$store.getters['warStore/getAllWarHistoryList'](page)
    },
  },
  created() {
    this.fetchWarHistoryList(this.currentPage)
  },
  watch: {
    gameRecordList() {
      window.scrollTo(0, 0)
    }
  },
}
</script>

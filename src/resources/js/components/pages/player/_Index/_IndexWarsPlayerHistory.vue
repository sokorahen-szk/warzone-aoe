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
import { mapGetters, mapActions } from 'vuex'
import Loading from '@atoms/Loading'

export default {
  name: 'IndexWarsPlayerHistory',
  components: {
    CommonOneColumnTemplate,
    GameRecordTablePc,
    GameRecordTableSp,
    Loading,
  },
  data() {
    return {
      playerId: this.$route.params['id'],
      isLoading: false,
      currentPage: 1,
      gameRecordList: []
    }
  },
  computed: {
    ...mapGetters({
      deviceType: 'breakpointStore/getDeviceType',
      gameRecordTotalPage: 'warStore/getPlayerTotalPage',
    }),
  },
  methods: {
    ...mapActions({
      fetchWarHistoryListToStore: 'warStore/fetchPlayerWarHistoryList'
    }),
    fetchWarHistoryList(page) {
      this.isLoading = true
      new Promise((resolve) => {
        resolve(this.fetchWarHistoryListToStore({'playerId': this.playerId, 'page': page}))
      })
      .then(res => {
        this.setGameRecordList(page)
      })
      .catch(err => {
        console.log(err)
      })
      .finally(() => {
        this.isLoading = false
      })
    },
    changePage(val){
      this.currentPage = val
      this.fetchWarHistoryList(this.currentPage)
    },
    setGameRecordList(page) {
      if(!page){
        return
      }
      this.gameRecordList = this.$store.getters['warStore/getPlayerWarHistoryList']({'playerId': this.playerId, 'page': page})
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
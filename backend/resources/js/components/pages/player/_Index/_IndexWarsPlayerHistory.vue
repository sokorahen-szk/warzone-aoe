<template>
  <CommonOneColumnTemplate>
    <template slot="container">
      <Loading v-if="isLoading" />
      <GameRecordTable
        v-else
        :gameRecordList="gameRecordList"
        :gameRecordTotalPage="gameRecordTotalPage"
        :currentPage="currentPage"
        @pageChange="pageChange"
      />
    </template>
  </CommonOneColumnTemplate>
</template>

<script>
import CommonOneColumnTemplate from '@templates/CommonOneColumnTemplate'
import GameRecordTable from '@organisms/GameRecordTable'
import { mapGetters, mapActions } from 'vuex'
import Loading from '@atoms/Loading'

export default {
  name: 'IndexWarsPlayerHistory',
  components: {
    CommonOneColumnTemplate,
    GameRecordTable,
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
      getDeviceType: 'breakpointStore/getDeviceType',
      gameRecordTotalPage: 'warStore/getPlayerTotalPage',
    }),
  },
  methods: {
    ...mapActions({
      fetchWarHistoryListToStore: 'warStore/fetchPlayerWarHistoryList'
    }),
    fetchWarHistoryList(page) {
      // 対象ページがキャッシュ済みなら、キャッシュデータを使用する
      console.log(this.existTargetPage(page))
      if(this.existTargetPage(page)){
        this.setGameRecordList(page)
        return
      }
      this.isLoading = true
      new Promise((resolve, reject) => {
        resolve(this.fetchWarHistoryListToStore({'playerId': this.playerId, 'page': page}))
      })
      .then(res => {
        this.setGameRecordList(page)
      })
      .catch(err => {
        reject(err)
      })
      .finally(() => {
        this.isLoading = false
      })
    },
    pageChange(val){
      this.currentPage = val
      this.fetchWarHistoryList(this.currentPage)
    },
    setGameRecordList(page) {
      if(!page){
        return
      }
      this.gameRecordList = this.$store.getters['warStore/getPlayerWarHistoryList']({'playerId': this.playerId, 'page': page})
    },
    existTargetPage(page) {
      if(!page){
        return false
      }
      return this.$store.getters['warStore/existPlayerTargetPage']({'playerId': this.playerId, 'page': page})
    }
  },
  created() {
    this.fetchWarHistoryList(this.currentPage)
  },
}
</script>
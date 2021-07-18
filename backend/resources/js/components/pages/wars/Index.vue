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
  name: 'Index',
  components: {
    CommonOneColumnTemplate,
    GameRecordTable,
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
      getDeviceType: 'breakpointStore/getDeviceType',
      gameRecordTotalPage: 'warStore/getAllTotalPage',
    }),
  },
  methods: {
    ...mapActions({
      fetchWarHistoryListToStore: 'warStore/fetchAllWarHistoryList'
    }),
    fetchWarHistoryList(page) {
      // 対象ページがキャッシュ済みなら、キャッシュデータを使用する
      if(this.existTargetPage(page)){
        this.setGameRecordList(page)
        return
      }
      this.isLoading = true
      new Promise((resolve, reject) => {
        resolve(this.fetchWarHistoryListToStore(page))
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
    pageChange(val) {
      this.currentPage = val
      this.fetchWarHistoryList(this.currentPage)
    },
    setGameRecordList(page) {
      if(!page){
        return
      }
      this.gameRecordList = this.$store.getters['warStore/getAllWarHistoryList'](page)
    },
    existTargetPage(page) {
      if(!page){
        return false
      }
      return this.$store.getters['warStore/existAllTargetPage'](page)
    }
  },
  created() {
    this.fetchWarHistoryList(this.currentPage)
  },
}
</script>

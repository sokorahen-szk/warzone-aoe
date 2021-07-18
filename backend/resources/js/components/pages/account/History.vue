<template>
  <CommonWithRightColumnTemplate
    outlined
    :device="getDeviceType"
  >
    <template slot="right">
      <AccountRightMenu />
    </template>
    <template slot="container">
      <v-container>
        <Loading v-if="isLoading" />
        <GameRecordTable
          v-else
          :gameRecordList="gameRecordList"
          :gameRecordTotalPage="gameRecordTotalPage"
          :currentPage="currentPage"
          @pageChange="pageChange"
        />
      </v-container>
    </template>
  </CommonWithRightColumnTemplate>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import CommonWithRightColumnTemplate from '@templates/CommonWithRightColumnTemplate'
import AccountRightMenu from '@organisms/AccountRightMenu'
import GameRecordTable from '@organisms/GameRecordTable'
import Loading from '@atoms/Loading'

export default {
  name: 'AccountHistory',
  components: {
    CommonWithRightColumnTemplate,
    AccountRightMenu,
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
      gameRecordTotalPage: 'warStore/getUserTotalPage',
      userId: 'accountStore/getUserId'
    }),
  },
  methods: {
    ...mapActions({
      fetchWarHistoryListToStore: 'warStore/fetchUserWarHistoryList'
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
        resolve(this.fetchWarHistoryListToStore({'userId': this.userId, 'page': page}))
      })
      .then(res => {
        this.setGameRecordList(page)
      })
      .catch(err => {
        reject(err);
      })
      .finally(() => {
        this.isLoading = false;
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
      this.gameRecordList = this.$store.getters['warStore/getUserWarHistoryList'](page)
    },
    existTargetPage(page) {
      if(!page){
        return false
      }
      return this.$store.getters['warStore/existUserTargetPage'](page)
    }
  },
  created() {
    this.fetchWarHistoryList(this.currentPage)
  },
}
</script>
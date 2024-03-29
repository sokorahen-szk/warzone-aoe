<template>
  <CommonWithRightColumnTemplate
    outlined
    :device="deviceType"
    cardPaClass="pa-0"
  >
    <template slot="right">
      <AccountRightMenu :role="profileView.role" />
    </template>
    <template slot="container">
      <Loading v-if="isLoading" size="64" class="py-4" />
      <div v-else>
        <GameRecordTablePc
          v-if="breakPoint == 'lg' || breakPoint == 'xl'"
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
  </CommonWithRightColumnTemplate>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import CommonWithRightColumnTemplate from '@templates/CommonWithRightColumnTemplate'
import AccountRightMenu from '@organisms/AccountRightMenu'
import GameRecordTablePc from '@organisms/pc/GameRecordTable'
import GameRecordTableSp from '@organisms/sp/GameRecordTable'
import Loading from '@atoms/Loading'
import { profileViewTemplate } from '@/config/account'
import { objCopy } from '@/services/helper'

export default {
  name: 'AccountHistory',
  components: {
    CommonWithRightColumnTemplate,
    AccountRightMenu,
    GameRecordTablePc,
    GameRecordTableSp,
    Loading,
  },
  data() {
    return {
      profileView: profileViewTemplate,
      isLoading: false,
      currentPage: 1,
      gameRecordList: []
    }
  },
  computed: {
    ...mapGetters('accountStore', ['getProfile']),
    ...mapGetters({
      deviceType: 'breakpointStore/getDeviceType',
      breakPoint: 'breakpointStore/getBreakPoint',
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
      if(this.existTargetPage(page)){
        this.setGameRecordList(page)

        return
      }
      this.isLoading = true
      new Promise((resolve) => {
        resolve(this.fetchWarHistoryListToStore({'userId': this.userId, 'page': page}))
      })
      .then(res => {
        this.setGameRecordList(page)
      })
      .finally(() => {
        this.isLoading = false;
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
  watch: {
    gameRecordList() {
      window.scrollTo(0, 0)
    }
  },
  mounted() {
    this.$store.subscribe((mutation) => {
      if (mutation.type === 'accountStore/setProfile') {
        this.$set(this, 'profileView', objCopy(this.profileView, this.getProfile))
      }
    })
    this.$set(this, 'profileView', objCopy(this.profileView, this.getProfile))
  },
}
</script>
<template>
  <CommonOneColumnTemplate>
    <template slot="container">
      <Loading v-if="isLoading" />
      <GameRecordTable
        v-else
        :gameRecordList="gameRecordList"
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
      isLoading: false
    }
  },
  computed: {
    ...mapGetters({
      getDeviceType: 'breakpointStore/getDeviceType',
      gameRecordList: 'warStore/getWarHistoryList'
    }),
  },
  methods: {
    ...mapActions({
      fetchWarHistoryListToStore: 'warStore/fetchWarHistoryList'
    }),
    fetchWarHistoryList() {
      this.isLoading = true
      new Promise((resolve, reject) => {
        resolve(this.fetchWarHistoryListToStore())
      })
      .then(res => {
        // 取得に成功した時の処理
      })
      .catch(err => {
        reject(err);
      })
      .finally(() => {
        this.isLoading = false;
      })
    }
  },
  created() {
    this.fetchWarHistoryList();
  },
}
</script>

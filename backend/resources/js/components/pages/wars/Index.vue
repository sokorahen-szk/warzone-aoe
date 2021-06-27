<template>
  <CommonOneColumnTemplate>
    <template slot="container">
      <GameRecordTable />
    </template>
  </CommonOneColumnTemplate>
</template>

<script>
import CommonOneColumnTemplate from '@/components/templates/CommonOneColumnTemplate'
import GameRecordTable from '@/components/organisms/GameRecordTable'

export default {
  name: 'Index',
  components: {
    CommonOneColumnTemplate,
    GameRecordTable,
  },
  data() {
    return {
      //
    }
  }
}
</script>

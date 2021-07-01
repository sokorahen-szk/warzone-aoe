<template>
  <CommonOneColumnTemplate>
    <template slot="container">
      <GameRecordTable />
    </template>
  </CommonOneColumnTemplate>
</template>

<script>
import CommonOneColumnTemplate from '@templates/CommonOneColumnTemplate'
import GameRecordTable from '@organisms/GameRecordTable'

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

<template>
  <CommonOneColumnTemplate>
    <template slot="container">
      <GameRecordFullTable />
    </template>
  </CommonOneColumnTemplate>
</template>

<script>
import CommonOneColumnTemplate from '@/components/templates/CommonOneColumnTemplate'
import GameRecordFullTable from '@/components/organisms/GameRecordFullTable'

export default {
  name: 'Index',
  components: {
    CommonOneColumnTemplate,
    GameRecordFullTable,
  },
  data() {
    return {
      //
    }
  }
}
</script>

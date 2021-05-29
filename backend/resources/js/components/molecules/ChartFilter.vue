<template>
  <div>
    <v-chip
      v-for="(filter, index) in filters"
      :key="`chart-filter-${index}`"
      class="ma-1"
      :color="filter.id === selected ? 'primary' : ''"
      @click="selected = filter.id"
    >
      {{filter.label}}
    </v-chip>
  </div>
</template>

<script>
import {chartFilter} from '@/config/global'
export default {
  name: 'ChartFilter',
  props: {
    selectedDefault: {type: Number},
  },
  data() {
    return {
      filters: chartFilter,
      selected: this.selectedDefault,
    }
  },
  watch: {
    selected(val) {
      return this.$emit('change', val)
    }
  }
}
</script>
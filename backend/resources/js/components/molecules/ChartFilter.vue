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
export default {
  name: 'ChartFilter',
  data() {
    return {
      filters: [
        {id: 1, label: '今月'},
        {id: 2, label: '先月'},
        {id: 3, label: '今年'},
        {id: 4, label: '去年'},
      ],
      selected: 1
    }
  },
}
</script>
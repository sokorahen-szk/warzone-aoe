<template>
  <v-row>
    <template v-for="(gamePackage) in gamePackages">
    <v-col
      cols="6"
      sm="6"
      :md="Math.ceil(12 / gamePackages.length)"
      :lg="Math.ceil(12 / gamePackages.length)"
      :key="gamePackage.id"
    >
      <SelectCard
        :item="gamePackage"
        @click="select($event, gamePackage.id)"
      />
    </v-col>
    </template>
  </v-row>
</template>

<script>
import SelectCard from '@/components/molecules/SelectCard'
export default {
  name: 'GamePackage',
  components: {
    SelectCard
  },
  props: {
    gamePackages: {type: Array, default: []},
  },
  data() {
    return {
      selectedItems: []
    }
  },
  methods: {
    select(val, key) {
      if (val) {
        this.selectedItems.push(key)
      } else {
       if(this.selectedItems.indexOf(key) != -1) this.selectedItems.splice(this.selectedItems.indexOf(key), 1);
      }

      return this.$emit('update', this.selectedItems)
    }
  }
}
</script>
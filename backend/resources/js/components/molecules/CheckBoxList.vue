<template>
  <ul class="check-box-list">
    <li v-for="(item, index) in items" :key="item.label">
      <CheckBox
        :selected="item.selected"
        :label="item.label"
        :value="item.value"
        @update="updateValue(index, $event)"
      />
    </li>
  </ul>
</template>

<style scoped>
.check-box-list {
  list-style-type: none;
  padding: 0px;
  margin: 0px;
}
* >>> .v-messages {
  min-height: 0px !important;
}
</style>

<script>
import CheckBox from '@/components/atoms/CheckBox'
export default {
  name: 'CheckBoxList',
  props: {
    items: {type: Array, default: []},
  },
  components: {
    CheckBox
  },
  data() {
    return {
      data: new Array(this.items.length),
    }
  },
  watch: {
    data: {
      handler() {
        return this.$emit('update', this.data)
      },
      deep: true,
    }
  },
  methods: {
    updateValue(key, value) {
      this.data[key] = value
      this.data.splice();
    }
  }
}
</script>
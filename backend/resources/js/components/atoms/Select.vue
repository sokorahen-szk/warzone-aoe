<template>
  <label>
    <select @change="updateValue" :disabled="disabled" :class="[{disabled: disabled}]" :style="addStyle">
      <option>{{ label }}</option>
      <template v-for="(item, index) in items">
        <option :value="item.value" :key="item['id'] ? item['id'] : index" :selected="item['id'] == selectedIndex">
          {{ item.label }}
        </option>
      </template>
    </select>
  </label>
</template>

<script>
import {addStyleParser} from '@/services/helper'
export default {
  name: 'Select',
  props: {
    items: {type: Array, default: []},
    selectedIndex: {type: [Number, String]},
    disabled: {type: Boolean, default: false},
    label: {type: String, default: '' },
    width: {type: String, default: '100%' },
    height: {type: String, default: '35px' },
    background: {type: String, default: '#fff' },
  },
  data() {
    return {
      enabled: true,
    }
  },
  methods: {
    updateValue(e) {
      this.$emit('input', e.target.value);
    },
  },
  computed: {
    addStyle() {
      return addStyleParser({
        background: `${this.background}`,
      })
    }
  },
}
</script>

<style scoped>
select {
  outline: none;
  text-indent: 4px;
  text-overflow: '';
  vertical-align: middle;
  font-size: inherit;
  color: inherit;
  -webkit-appearance: button;
  -moz-appearance: button;
  appearance: button;
  border: 1px #ccc solid;
  padding: 5px 0 5px 0;
  width: 100%;
  height: 100%;
  max-height: 55px;
  min-height: 40px;
  font-size: 12px;
}
.white {
  background: #fff;
}
select option {
  background-color: #fff;
  color: #333;
}
select::-ms-expand {
  display: none;
}
select:-moz-focusring {
  color: transparent;
  text-shadow: 0 0 0 #828c9a;
}
.disabled {
  background-color: #ECEFF1;
}
.err-text {
  color: #ff0000;
  font-size: 12px;
}
</style>

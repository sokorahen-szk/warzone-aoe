<template>
  <label>
    <select @change="updateValue" :disabled="disabled" :class="[{'disabled': disabled}]" :style="[addStyle]">
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
export default {
  name: 'Select',
  props: {
    items: {type: Array, default: []},
    selectedIndex: {type: [Number, String]},
    disabled: {type: Boolean, default: false},
    label: {type: String, default: '' },
    width: {type: String, default: '100%' },
    height: {type: String, default: '35px' },
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
      return {width: this.width, height: this.height};
    }
  },
}
</script>

<style scoped>
select {
  outline: none;
  text-indent: 0.01px;
  text-overflow: '';
  background: none transparent;
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
  font-size: 12px;
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

<template>
    <v-select
        class="pa-0 ma-0"
        :items="setItems"
        :dense="dense"
        :rules="setRule"
        :disabled="disabled"
        :required="required"
        :label="label"
        :placeholder="placeholder"
        :solo="solo"
        v-model="selectItem"
        @change="updateValue"
        :hide-details="hideDetails"
        :flat="flat"
        :outlined="outlined"
    ></v-select>
</template>

<script>
import { validator } from '@/services/validator'
export default {
    name: 'SelectBox',
    props: {
        items: {type: Array, default: []},
        selectedIndex: {type: [Number, String], default: 0},
        label: {type: String},
        dense: {type: Boolean, default: false},
        rules: {type: Object, default: null},
        disabled: {type: Boolean, default: false},
        required: {type: Boolean, default: false},
        placeholder: {type: String, default: null},
        solo: {type: Boolean, default: false},
        hideDetails: {type: Boolean, default: false},
        flat: {type: Boolean, default: false},
        outlined: {type: Boolean, default: false},
    },
    data() {
        return {
            selectItem: null,
            list: [],
        }
    },
    methods: {
        updateValue(v) {
            this.$emit('input', v);
        },
    },
    computed: {
        setRule() {
            return validator(this.rules);
        },
        setColor() {
            return this.disabled ? '#eee' : '#fffffe'
        },
        setItems() {
            if (Array.isArray(this.items)) {
                this.items.forEach( (item) => {
                    this.list.push({
                        text: item.label,
                        value: item.value,
                    })
                })
            } else {
                this.list.push({
                    text: this.items.label,
                    value: this.items.value,
                })
            }

            if (this.list.length >= this.selectedIndex) {
                this.selectItem = this.list[Number(this.selectedIndex) - 1]
            }

            return this.list
        }
    },
}
</script>
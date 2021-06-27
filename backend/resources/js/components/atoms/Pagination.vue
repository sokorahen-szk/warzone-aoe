<template>
	<v-pagination
		v-model="current"
		class="my-4"
		:length="length"
		:total-visible="totalVisible"
	></v-pagination>
</template>

<script>
export default {
	name: 'Pagination',
	props: {
		length: {type: [Number, String]},
		current: {type: [Number, String]},
		totalVisible: {type: [Number, String], default: 6},
	},
	data() {
		return {
		}
	}
}
</script>

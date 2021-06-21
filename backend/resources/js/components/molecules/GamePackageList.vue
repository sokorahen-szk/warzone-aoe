<template>
	<div>
		<Label tag>AoE2HD</Label>
	</div>
</template>

<script>
import Label from '@/components/atoms/Label'
export default {
	name: 'GamePackageList',
  	components: {
		Label
	},
	props: {
		gamePackages: {type: Array},
		hasPackages: {type: Array},
	},
	data() {
		return {
			//
		}
	}
}
</script>

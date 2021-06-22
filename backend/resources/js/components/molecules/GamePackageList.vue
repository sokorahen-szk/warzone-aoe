<template>
	<div>
		<template v-for="gamePackage in gamePackages">
		<Label tag :key="gamePackage.id" v-if="hasGamePackage(gamePackage.id)">{{gamePackage.name}}</Label>
		</template>
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
		hasGamePackages: {type: Array, default: []},
	},
	data() {
		return {
			//
		}
	},
	methods: {
		hasGamePackage(gamePackageId) {
			if (!this.hasGamePackages) {
				return false
			}
			return this.hasGamePackages.find( (id) => Number(id) == gamePackageId)
		}
	},
}
</script>

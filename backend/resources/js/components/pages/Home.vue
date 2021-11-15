<template>
	<v-container>
		<CommonWithLeftColumnTemplate
		    :device="getDeviceType"
		>
			<template slot="container">
				aaa
			</template>
			<template slot="left">
				a
			</template>
		</CommonWithLeftColumnTemplate>
	</v-container>
</template>

<script>
import CommonWithLeftColumnTemplate from '@templates/CommonWithLeftColumnTemplate'
import { mapGetters } from 'vuex'
export default {
	name: 'Home',
	components: {
		CommonWithLeftColumnTemplate,
	},
	computed: {
		...mapGetters('breakpointStore', ['getDeviceType']),
	},
	data() {
		return {
			//
		}
	}
}
</script>

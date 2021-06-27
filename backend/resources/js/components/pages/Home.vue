<template>
	<v-container>
		<CommonWithLeftColumnTemplate
		    :device="getDeviceType"
		>
			<template slot="container">
				aaa
			</template>
			<template slot="left">
				<RankingColumn
					icon="mdi-format-list-bulleted"
					title="ゲーム数ランキング"
				/>
			</template>
		</CommonWithLeftColumnTemplate>
	</v-container>
</template>

<script>
import CommonWithLeftColumnTemplate from '@/components/templates/CommonWithLeftColumnTemplate'
import RankingColumn from '@/components/organisms/RankingColumn'
import { mapGetters } from 'vuex'
export default {
	name: 'Home',
	components: {
		CommonWithLeftColumnTemplate,
		RankingColumn
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

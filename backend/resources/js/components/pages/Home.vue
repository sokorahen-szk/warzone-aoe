<template>
	<v-container>
		<CommonWithLeftColumnTemplate>
			<template slot="container">
				aaa
			</template>
			<template slot="left">
				<ColumnBox />
			</template>
		</CommonWithLeftColumnTemplate>
	</v-container>
</template>

<script>
import CommonWithLeftColumnTemplate from '@/components/templates/CommonWithLeftColumnTemplate'
import ColumnBox from '@/components/organisms/ColumnBox'
export default {
	name: 'Home',
	components: {
		CommonWithLeftColumnTemplate,
		ColumnBox
	},
	data() {
		return {
			//
		}
	}
}
</script>

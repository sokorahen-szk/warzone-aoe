<template>
	<v-container>
		<CommonWithLeftColumnTemplate
		    :device="getDeviceType"
		>
			<template slot="container">
                <div class="text-h6">リリースノート</div>
                リリースした内容などはこちらに。
            </template>
        </CommonWithLeftColumnTemplate>
	</v-container>
</template>

<script>
import CommonWithLeftColumnTemplate from '@templates/CommonWithLeftColumnTemplate'
import { mapGetters } from 'vuex'
export default {
	name: 'News',
	components: {
		CommonWithLeftColumnTemplate,
    },
	computed: {
		...mapGetters('breakpointStore', ['getDeviceType']),
    }
}
</script>

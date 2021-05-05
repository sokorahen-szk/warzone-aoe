<template>
  <v-container>
    <CommonWithRightColumnTemplate outlined>
			<template slot="right">
        <AccountRightMenu />
			</template>
			<template slot="container">
				<v-container>
          あ
        </v-container>
			</template>
    </CommonWithRightColumnTemplate>
  </v-container>
</template>

<script>
import CommonWithRightColumnTemplate from '@/components/templates/CommonWithRightColumnTemplate'
import AccountRightMenu from '@/components/organisms/AccountRightMenu'
export default {
  name: 'Request',
  components: {
    CommonWithRightColumnTemplate,
    AccountRightMenu
  },
  data() {
    return {
      //
    }
  }
}
</script>
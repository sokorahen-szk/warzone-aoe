<template>
  <v-container>
    <CommonWithRightColumnTemplate>
			<template slot="right">
        <AccountRightMenu />
			</template>
			<template slot="container">
				<v-container>
          対戦履歴
        </v-container>
			</template>
    </CommonWithRightColumnTemplate>
  </v-container>
</template>

<script>
import CommonWithRightColumnTemplate from '@/components/templates/CommonWithRightColumnTemplate'
import AccountRightMenu from '@/components/organisms/AccountRightMenu'
export default {
  name: 'AccountHistory',
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
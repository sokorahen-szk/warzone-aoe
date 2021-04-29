<template>
  <div>
    <CommonWithRightColumnTemplate>
			<template slot="right">
        <AccountRightMenu />
			</template>
			<template slot="container">
				<v-container>
          aaaasa
        </v-container>
			</template>
    </CommonWithRightColumnTemplate>
  </div>
</template>

<script>
import CommonWithRightColumnTemplate from '@/components/templates/CommonWithRightColumnTemplate'
import AccountRightMenu from '@/components/organisms/AccountRightMenu'
export default {
  name: 'Profile',
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
<template>
  <div>
    <CommonWithRightColumnTemplate>
			<template slot="right">
        <AccountRightMenu />
			</template>
			<template slot="container">
				a
			</template>
    </CommonWithRightColumnTemplate>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import CommonWithRightColumnTemplate from '@/components/templates/CommonWithRightColumnTemplate'
import AccountRightMenu from '@/components/organisms/AccountRightMenu'
export default {
  name: 'AccountMypage',
  components: {
    CommonWithRightColumnTemplate,
    AccountRightMenu
  },
  data() {
    return {
      //
    }
  },
  computed: {
    ...mapGetters('accountStore', ['getProfile']),
  },
}
</script>

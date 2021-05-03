<template>
  <v-container>
    <CommonWithRightColumnTemplate outlined>
			<template slot="right">
        <AccountRightMenu />
			</template>
			<template slot="container">
        <v-row no-gutters>
          <v-col cols="12">
            <div class="py-2">退会手続き</div>
            <div class="text-center">
              <v-icon size="64" color="red">mdi-alert</v-icon>
            </div>
            <div class="text-center py-2">
              退会手続きの前にご確認ください
            </div>
            <v-row no-gutters justify="center" align-content="center" style="height: 75px;">
              <CheckBoxList
                :items="question"
                @update="valid = !valid"
              />
            </v-row>
            <div class="text-center mb-4">
              <Button
                width="150"
                height="45"
                color="error"
                label="退会する"
                @click="withdrawalEvent"
                :disabled="!valid"
              ></Button>
            </div>
          </v-col>
        </v-row>
			</template>
    </CommonWithRightColumnTemplate>
  </v-container>
</template>

<script>
import CommonWithRightColumnTemplate from '@/components/templates/CommonWithRightColumnTemplate'
import AccountRightMenu from '@/components/organisms/AccountRightMenu'
import Button from '@/components/atoms/Button'
import CheckBoxList from '@/components/molecules/CheckBoxList'
export default {
  name: 'Withdrawal',
  components: {
    CommonWithRightColumnTemplate,
    AccountRightMenu,
    Button,
    CheckBoxList
  },
  data() {
    return {
      valid: false,
      question: [{selected: false, label: "アカウントを停止することに同意する", value: true}],
    }
  },
  methods: {
    withdrawalEvent() {
      // ここに退会処理
    }
  }
}
</script>
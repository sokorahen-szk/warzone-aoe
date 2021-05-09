<template>
  <v-container>
    <CommonWithRightColumnTemplate outlined>
			<template slot="right">
        <AccountRightMenu />
			</template>
			<template slot="container">
				<v-container>
          <div class="subtitle-2">
            <v-row no-gutters no-wrap class="text-right">
              <v-col cols="12">新規リクエスト数：{{requests.length}} 件</v-col>
              <v-col cols="12">承認数：0 件</v-col>
              <v-col cols="12">キャンセル数：0 件</v-col>
            </v-row>
          </div>
          <v-list class="pa-0 ma-0">
            <template v-for="request in requests">
            <v-list-item class="pa-0 ma-0" :key="`v-list-item-${request.id}`">
              <v-list-item-content>
                <v-list-item-title>{{request.player_name}}</v-list-item-title>
                <v-list-item-subtitle>参加日：{{request.joinedAt}}</v-list-item-subtitle>
              </v-list-item-content>
              <v-list-item-action>
                <v-row no-gutters>
                  <v-col>
                    <v-icon @click="edit(request.id)">mdi-clipboard-edit-outline</v-icon>
                  </v-col>
                  <v-col>
                    <v-icon color="green">mdi-check-bold</v-icon>
                  </v-col>
                  <v-col>
                    <v-icon color="red">mdi-close-thick</v-icon>
                  </v-col>
                </v-row>
              </v-list-item-action>
            </v-list-item>
            <v-card :key="`v-card-${request.id}`" class="pa-4">
              <TextArea
                outlined
                placeholder="備考"
                class="pa-0 ma-0"
              />
              <div class="text-right">
                <Button color="success" label="承認" />
                <Button color="error" label="拒否" />
              </div>
            </v-card>
            <v-divider :key="`v-list-item-divider-${request.id}`" />
            </template>
          </v-list>
        </v-container>
			</template>
    </CommonWithRightColumnTemplate>
  </v-container>
</template>

<script>
import CommonWithRightColumnTemplate from '@/components/templates/CommonWithRightColumnTemplate'
import AccountRightMenu from '@/components/organisms/AccountRightMenu'
import TextArea from '@/components/atoms/TextArea'
import Button from '@/components/atoms/Button'
export default {
  name: 'Request',
  components: {
    CommonWithRightColumnTemplate,
    AccountRightMenu,
    TextArea,
    Button
  },
  data() {
    return {
      requests: [
        {id: 2, player_name: "テストユーザ", joinedAt: "2021-03-22 00:00:00"},
        {id: 3, player_name: "テストユーザa", joinedAt: "2021-04-19 12:00:00"},
      ]
    }
  },
  methods: {
    edit(id) {
      console.log(id)
    }
  }
}
</script>
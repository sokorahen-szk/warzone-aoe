<template>
  <CommonWithRightColumnTemplate
    outlined
    :device="getDeviceType"
  >
    <template slot="header">
      <Alert :properties="alert" dense />
    </template>
    <template slot="right">
      <AccountRightMenu />
    </template>
    <template slot="container">
      <v-container>
        <div class="subtitle-2">
          <v-row no-gutters no-wrap class="text-right mb-4">
            <v-col cols="12">新規リクエスト数：{{ this.requests.length }} 件</v-col>
            <!--
              TODO: 今後実装予定の場所
              https://github.com/sokorahen-szk/warzone-aoe/issues/40
            -->
            <!--v-col cols="12">承認数：0 件</v-col-->
            <!--v-col cols="12">拒否数：0 件</v-col-->
          </v-row>
        </div>
        <v-list class="pa-0 ma-0" v-if="requests.length > 0">
          <template v-for="(request, index) in requests">
          <v-list-item class="pa-0 ma-0" :key="`v-list-item-${request.id}`">
            <v-list-item-content>
              <v-list-item-title>{{request.playerName}}</v-list-item-title>
              <v-list-item-subtitle>参加日：{{request.joinedAt}}</v-list-item-subtitle>
            </v-list-item-content>
            <v-list-item-action>
              <v-row no-gutters>
                <v-col>
                  <v-icon size="36" @click="edit(index)">mdi-clipboard-edit-outline</v-icon>
                </v-col>
                <v-col>
                  <v-icon size="36" @click="approve(index)" color="green">mdi-check-bold</v-icon>
                </v-col>
                <v-col>
                  <v-icon size="36" @click="reject(index)" color="red">mdi-close-thick</v-icon>
                </v-col>
              </v-row>
            </v-list-item-action>
          </v-list-item>
          <v-card :key="`v-card-${request.id}`" class="pa-4" v-show="req[index] && req[index].view">
            <TextArea
              outlined
              placeholder="備考"
              class="pa-0 ma-0"
              @update="update($event, index)"
            />
            <div class="text-right">
              <Button
                color="success"
                label="承認"
                @click="approve(index)"
              />
              <Button
                color="error"
                label="拒否"
                @click="reject(index)"
              />
            </div>
          </v-card>
          <v-divider :key="`v-list-item-divider-${request.id}`" />
          </template>
        </v-list>
        <div v-else>新規リクエストがありません</div>
      </v-container>
    </template>
  </CommonWithRightColumnTemplate>
</template>

<script>
import CommonWithRightColumnTemplate from '@/components/templates/CommonWithRightColumnTemplate'
import AccountRightMenu from '@/components/organisms/AccountRightMenu'
import TextArea from '@/components/atoms/TextArea'
import Button from '@/components/atoms/Button'
import Alert from '@/components/atoms/Alert'
import { mapActions, mapGetters } from 'vuex'
import { alertTemplate } from '@/config/global'
import { registerRequestEnum } from '@/config/admin'
export default {
  name: 'Request',
  components: {
    CommonWithRightColumnTemplate,
    AccountRightMenu,
    TextArea,
    Button,
    Alert
  },
  data() {
    return {
      req: [],
      requests: [],
      alert: alertTemplate,
    }
  },
  mounted() {
    this.loadingData()

    this.$store.subscribe((mutation) => {
      if (mutation.type === 'adminStore/setRegisterRequests') {
        this.$set(this, 'requests', this.getRegisterRequests)

        this.$nextTick( () => {
          this.req.splice(0, this.req.length);
          this.requests.forEach( (item) => {
            this.req.push({
              id: item.id,
              view: false,
              remarks: null,
            })
          })
        })

      }
    })
  },
  computed: {
    ...mapGetters('adminStore', ['getRegisterRequests']),
    ...mapGetters('breakpointStore', ['getDeviceType']),
  },
  methods: {
    ...mapActions('adminStore', ['registerRequest', 'updateRegisterRequest']),
    loadingData() {
      new Promise((resolve) => {
        resolve(this.registerRequest())
      })
      .catch( (err) => {
        this.alert = Object.assign(alertTemplate, {
          show: true,
          type: 'error',
          message: err,
        })
      })
    },
    edit(index) {
      this.req[index] = Object.assign(this.req[index], {view: !this.req[index].view})
    },
    change(index, status) {
      const param = this.req[index]
      if (!param) return;

      new Promise((resolve) => {
        resolve(this.updateRegisterRequest({
          registerId: param.id,
          status: status,
          remarks: param.remarks,
        }))
      })
      .then ( (res) => {
        this.alert = Object.assign(alertTemplate, {
          show: true,
          type: 'info',
          message: res,
        })

        this.loadingData()
      })
      .catch( (err) => {
        this.alert = Object.assign(alertTemplate, {
          show: true,
          type: 'error',
          message: err,
        })
      })
    },
    approve(index) { this.change(index, registerRequestEnum.APPROVE) },
    reject(index) { this.change(index, registerRequestEnum.REJECT) },
    update($event, index) {
      this.req[index] = Object.assign(this.req[index], {remarks: $event})
    },
  }
}
</script>
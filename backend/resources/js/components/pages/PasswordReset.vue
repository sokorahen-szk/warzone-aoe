<template>
  <CommonOneColumnTemplate
    :device="getDeviceType"
    :sheetPaClass="'pa-3'"
  >
    <template slot="header">
      <Alert :properties="alert" dense />
    </template>
    <template slot="container">
      <v-form
        ref="form"
        v-model="valid"
        lazy-validation
      >
        <v-row no-gutters>
          <v-col cols="12">
            <v-row no-gutters justify="center" align-content="center" style="height: 500px;">

              <v-row no-gutters>
                <v-col offset-sm="3" offset-md="3" offset-lg="3" offset-xl="3"></v-col>
                <v-col cols="12" sm="6" md="6" lg="6" xl="6">

                  <div class="text-center my-4 headline">パスワード再設定</div>
                  <v-divider class="py-2" />

                  <div class="caption">
                  アカウント作成時にメールアドレスを設定している場合、パスワード再設定が<br />
                  可能です。入力いただいたメールアドレス宛にメールアドレス再設定のリンクが送られます。
                  </div>

                  <v-row class="mt-4">
                    <v-col cols="12" class="py-0 ma-0">
                      <TextInput
                        :value="email"
                        @update="email = $event"
                        placeholder="メールアドレス"
                        outlined
                        required
                        :rules="{label:'メールアドレス', types:'required'}"
                      />
                    </v-col>
                  </v-row>

                  <v-row>
                    <v-col cols="12" class="text-center">
                      <Button
                        label="送信する"
                        color="success"
                        @click="reset"
                        :disabled="!valid"
                        :loading="loading"
                        height="65"
                        width="200"
                        font-size="22"
                      />
                    </v-col>
                  </v-row>

                </v-col>
                <v-col offset-sm="3" offset-md="3" offset-lg="3" offset-xl="3"></v-col>
              </v-row>


            </v-row>
          </v-col>
        </v-row>
      </v-form>
    </template>
  </CommonOneColumnTemplate>
</template>

<script>
import CommonOneColumnTemplate from '@templates/CommonOneColumnTemplate'
import TextInput from '@atoms/TextInput'
import Button from '@atoms/Button'
import Alert from '@atoms/Alert'
import { mapActions, mapGetters } from 'vuex'
import { alertTemplate } from '@/config/global'
export default {
	name: 'PasswordReset',
    components: {
        CommonOneColumnTemplate,
        TextInput,
        Button,
        Alert,
    },
    computed: {
      ...mapGetters('breakpointStore', ['getDeviceType']),
    },
    data() {
      return {
        valid: true,
        email: null,

        loading: false,

        alert: alertTemplate,
      }
    },
    methods: {
      ...mapActions('accountStore', ['passwordReset']),
      reset() {
        if(!this.$refs.form.validate()) return;

        this.loading = true
        new Promise((resolve) => {
          resolve(this.passwordReset({email: this.email}))
        })
        .then( () => {
          alert("パスワード再設定のリンクを入力いただいたメールアドレス宛に\nお送りしました。メールボックスをご確認ください。")
        })
        .catch( (err) => {
          this.alert = Object.assign(alertTemplate, {
            show: true,
            type: 'error',
            message: err,
          })
        })
        .finally( () => {
          this.loading = false
        })
      }
    }
}
</script>

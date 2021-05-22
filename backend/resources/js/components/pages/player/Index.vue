<template>
  <CommonOneColumnTemplate>
    <template slot="container">
      <v-row no-gutters class="py-2">
        <v-col cols="12" sm="12" md="6" lg="5" xl="4">
          <v-row no-gutters>
            <v-col cols="12" class="text-center">
              <Avator
                size="200"
                src="https://hayabusa.io/openrec-image/user/2188980/218897971.q95.w164.ttl604800.headercache0.v1586754759.png?format=png"
              />
            </v-col>
          </v-row>
        </v-col>
        <v-col cols="12" sm="12" md="6" lg="7" xl="8">
          <v-row no-gutters>
            <v-col cols="12">
              <div class="text-h5"
                :class="{
                  'text-center py-3': getDeviceType == 'sp',
                }">
                titan
              </div>
              <div
                :class="{
                  'text-center': getDeviceType == 'sp',
                }">
                <Icon
                  href="https://yahoo.co.jp"
                  color="#29B6F6"
                >mdi-twitter</Icon>
                <Icon
                  href="https://yahoo.co.jp"
                  color="#37474F"
                >mdi-steam</Icon>
              </div>
              <div class="py-4">
                <v-card
                  outlined
                  class="pa-2"
                  height="100"
                >
                  初心者です。よろしくお願いします。
                </v-card>
              </div>
            </v-col>
          </v-row>
        </v-col>
        <v-col cols="12" class="pt-4 pb-2">
          <div>
            <Label tag>AoE2HD</Label><Label tag>AoE2DE</Label><Label tag>AoE2</Label>
          </div>
        </v-col>
        <v-col cols="12">
          <Tabs
            :grow="getDeviceType === 'sp'"
            :tabs="tabs"
            @change="selectTab = $event"
          />
          <div v-bind:is="component"></div>
        </v-col>
      </v-row>
    </template>
  </CommonOneColumnTemplate>
</template>

<script>
import CommonOneColumnTemplate from '@/components/templates/CommonOneColumnTemplate'
import IndexBasicPlayerProfile from '@/components/pages/player/_Index/_IndexBasicPlayerProfile'
import IndexWarsPlayerHistory from '@/components/pages/player/_Index/_IndexWarsPlayerHistory'
import IndexRatePlayerHisyory from '@/components/pages/player/_Index/_IndexRatePlayerHisyory'
import Avator from '@/components/atoms/Avator'
import Icon from '@/components/atoms/Icon'
import Label from '@/components/atoms/Label'
import Tabs from '@/components/molecules/Tabs'
import { mapGetters } from 'vuex'

export default {
  name: 'PlayerIndex',
  components: {
    CommonOneColumnTemplate,
    Avator,
    Icon,
    Label,
    Tabs,
    IndexBasicPlayerProfile,
    IndexWarsPlayerHistory,
    IndexRatePlayerHisyory,
  },
  computed: {
    ...mapGetters('breakpointStore', ['getDeviceType']),
    component: function(){
      return this.components[this.selectTab]
    }
  },
  data() {
    return {
      playerId: this.$route.params['id'],
      selectTab: 0,
      tabs: [
        {label: '基本情報', icon: 'mdi-account'},
        {label: '対戦履歴', icon: 'mdi-menu'},
        {label: 'レート遷移', icon: 'mdi-menu'},
      ],

      components: [
        'IndexBasicPlayerProfile',
        'IndexWarsPlayerHistory',
        'IndexRatePlayerHisyory',
      ]
    }
  },
}
</script>
<template>
  <CommonOneColumnTemplate>
    <template slot="container">
      <v-row no-gutters class="py-2">
        <v-col cols="12" sm="12" md="6" lg="5" xl="4">
          <v-row no-gutters>
            <v-col cols="12" class="text-center">
              <Avator
                size="200"
                :src="profile && profile.avatorImage"
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
                {{ profile && profile.player.name }}
              </div>
              <div
                :class="{
                  'text-center': getDeviceType == 'sp',
                }">
                <Icon
                  :href="profile && profile.twitterUrl"
                  color="#29B6F6"
                  v-show="profile && profile.twitterUrl"
                >mdi-twitter</Icon>
                <Icon
                  :href="profile && profile.steamUrl"
                  color="#37474F"
                  v-show="profile && profile.steamUrl"
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
              <div>登録日 {{ profile && toStringYYYYMM(profile.player.joinedAt) }}</div>
              <div
                v-if="isLogin && playerId == getProfile.player.id"
                class="text-right"
              >
                <Button
                  label="プロフィール編集"
                  tile
                  color="info"
                  path="/account/profile"
                />
              </div>
            </v-col>
          </v-row>
        </v-col>
        <v-col cols="12" class="pt-4 pb-2">
          <GamePackageList
            :gamePackages="getPackageList"
            :hasGamePackages="profile && profile.player.gamePackages"
          />
        </v-col>
        <v-col cols="12">
          <Tabs
            :grow="getDeviceType === 'sp'"
            :tabs="tabs"
            :selected-tab="selectTab"
            @change="selectTab = $event"
          />
          <div :is="component" v-bind="props"></div>
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
import Button from '@/components/atoms/Button'
import GamePackageList from '@/components/molecules/GamePackageList'
import Icon from '@/components/atoms/Icon'
import Tabs from '@/components/molecules/Tabs'
import { mapActions, mapGetters } from 'vuex'
import {playerProfileTab, findBySpecificKey} from '@/services/helper';
import {playerProfileTabs} from '@/config/player';

export default {
  name: 'PlayerIndex',
  components: {
    CommonOneColumnTemplate,
    Avator,
    Icon,
    Tabs,
    Button,
    IndexBasicPlayerProfile,
    IndexWarsPlayerHistory,
    IndexRatePlayerHisyory,
    GamePackageList,
  },
  mounted() {
    this.loadPlayerProfile();

    this.$store.subscribe((mutation) => {
      if (mutation.type === 'playerStore/setPlayerProfile') {
        this.$set(this, 'profile', this.getPlayerProfile)
        this.$set(this.props, 'profile', this.getPlayerProfile)
      }
    })
  },
  computed: {
    ...mapGetters('breakpointStore', ['getDeviceType']),
    ...mapGetters('playerStore', ['getPlayerProfile']),
    ...mapGetters('gameStore', ['getPackageList']),
    ...mapGetters('authStore', ['isLogin']),
    ...mapGetters('accountStore', ['getProfile']),
    component: function(){
      return findBySpecificKey(playerProfileTabs, this.selectTab, 'id', 'component')
    },
    tabs() {
      return playerProfileTabs
    }
  },
  methods: {
    ...mapActions('playerStore', ['playerProfile']),
    loadPlayerProfile() {
      this.playerProfile({id: this.playerId})
    },
    toStringYYYYMM(date) {
      return this.$dayjs(date).format('YYYY年MM月DD日')
    }
  },
  data() {
    return {
      playerId: this.$route.params['id'],
      profile: null,
      selectTab: findBySpecificKey(playerProfileTabs, this.$route.query['tab'] || 'profile', 'name', 'id'),

      props: {
        id: this.$route.params['id'],
        profile: null,
      },
    }
  },
}
</script>
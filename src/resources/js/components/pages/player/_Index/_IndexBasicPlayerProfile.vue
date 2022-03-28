<template>
  <v-container>
    <v-row no-gutters>
      <v-col cols="6" sm="6" md="3" lg="3" class="pa-1 mb-2">
        <v-card tile elevation="1">
          <v-row no-gutters class="text-center">
            <v-col class="py-3 subtitle-1">
              <div>ゲーム数</div>
              {{ profile && profile.player.games || 0 }}
            </v-col>
          </v-row>
        </v-card>
      </v-col>
      <v-col cols="6" sm="6" md="3" lg="3" class="pa-1 mb-2">
        <v-card tile elevation="1">
          <v-row no-gutters class="text-center">
            <v-col class="py-3 subtitle-1">
              <div>勝ち</div>
              {{ profile && profile.player.win || 0 }}
            </v-col>
          </v-row>
        </v-card>
      </v-col>
      <v-col cols="6" sm="6" md="3" lg="3" class="pa-1 mb-2">
        <v-card tile elevation="1">
          <v-row no-gutters class="text-center">
            <v-col class="py-3 subtitle-1">
              <div>負け</div>
              {{ profile && profile.player.defeat || 0 }}
            </v-col>
          </v-row>
        </v-card>
      </v-col>
      <v-col cols="6" sm="6" md="3" lg="3" class="pa-1 mb-2">
        <v-card tile elevation="1">
          <v-row no-gutters class="text-center">
            <v-col class="py-3 subtitle-1">
              <div>勝率</div>
              {{ profile && profile.player.wp || 0 }} %
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>
    <v-row no-gutters class="pa-3">
      <v-col cols="6" sm="6" md="4" lg="3">
        ランク
      </v-col>
      <v-col cols="6" sm="6" md="8" lg="9">
        {{ profile && profile.player.rank }}
      </v-col>
    </v-row>
    <v-row no-gutters class="pa-3">
      <v-col cols="6" sm="6" md="4" lg="3">
        最終ゲーム日
      </v-col>
      <v-col cols="6" sm="6" md="8" lg="9">
        {{ profile && profile.player.lastGameAt && toStringYYYYMM(profile.player.lastGameAt) }}
      </v-col>
    </v-row>
    <v-row no-gutters class="pa-3">
      <v-col cols="6" sm="6" md="4" lg="3">
        ウェブサイト
      </v-col>
      <v-col cols="6" sm="6" md="8" lg="9">
        {{ profile && profile.webSiteUrl }}
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import PopOverMenu from '@molecules/PopOverMenu'
export default {
  name: 'IndexBasicPlayerProfile',
  components: {
    PopOverMenu
  },
  props: {
    id: {type: [Number, String]},
    profile: {type: Object},
  },
  data() {
    return {
      //
    }
  },
  methods: {
    toStringYYYYMM(date) {
      return this.$dayjs(date).format('YYYY年MM月DD日')
    }
  }
}
</script>
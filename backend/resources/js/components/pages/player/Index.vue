<template>
  <CommonOneColumnTemplate>
    <template slot="container">
      <v-row no-gutters>
        <v-col cols="12" sm="12" md="6" lg="5" xl="4">
          <v-row no-gutters>
            <v-col cols="12" class="text-center">
              <Avator
                size="200"
                src="https://hayabusa.io/openrec-image/user/2188980/218897971.q95.w164.ttl604800.headercache0.v1586754759.png?format=png"
              />
            </v-col>
            <v-col cols="12">

            </v-col>
          </v-row>
        </v-col>
        <v-col cols="12" sm="12" md="6" lg="7" xl="8">
          <v-row no-gutters>
            <v-col cols="12">
              <div class="text-h6"
                :class="{
                  'text-center py-3': getDeviceType == 'sp',
                }">
                勇気 ちひろ
              </div>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </template>
  </CommonOneColumnTemplate>
</template>

<script>
import CommonOneColumnTemplate from '@/components/templates/CommonOneColumnTemplate'
import Avator from '@/components/atoms/Avator'
import { mapGetters } from 'vuex'

export default {
  name: 'PlayerIndex',
  components: {
    CommonOneColumnTemplate,
    Avator
  },
  computed: {
    ...mapGetters('breakpointStore', ['getDeviceType']),
  },
  data() {
    return {
      playerId: this.$route.params['id']
    }
  },
}
</script>
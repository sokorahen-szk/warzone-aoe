<template>
  <div>
    <v-sheet
      color="white"
      :elevation="setElevation"
      center-active
    >
      <v-toolbar
        flat
        dense
        height="55"
      >
      <v-icon v-if="icon" class="mr-2">{{icon}}</v-icon>{{title}}
      </v-toolbar>
      <v-divider></v-divider>
      <v-tabs
        background-color="transparent"
        grow
      >
        <v-tab>週間</v-tab>
        <v-tab>月間</v-tab>
        <v-tab>通算</v-tab>
      </v-tabs>

      <PlayerList
        :players="items"
      />

      <div class="pa-2">
        <Button
          depressed
          block
          label="もっと見る"
          @click="clickMore"
        />
      </div>

    </v-sheet>
  </div>
</template>

<script>
import PlayerList from '@/components/molecules/PlayerList'
import Button from '@/components/atoms/Button'
export default {
  name: 'ColumnBox',
  props: {
    elevation : {type: Boolean, default: false},
    icon: {type: String, default: null},
    title: {type: String, default: null},
  },
  components: {
    PlayerList,
    Button
  },
  data() {
    return {
      items : [
        {id: 1, rank: 20, name: 'AAAA', image: 'https://image.shutterstock.com/image-vector/sample-stamp-grunge-texture-vector-600w-1389188327.jpg', linkEnabled: true},
        {id: 2, rank: 20, name: 'AAAA', image: 'https://image.shutterstock.com/image-vector/sample-stamp-grunge-texture-vector-600w-1389188327.jpg', linkEnabled: true},
        {id: 3, rank: 20, name: 'AAAA', image: 'https://image.shutterstock.com/image-vector/sample-stamp-grunge-texture-vector-600w-1389188327.jpg', linkEnabled: true},
      ]
    }
  },
  computed: {
    setElevation() {
      return this.elevation ? 1 : 0
    }
  },
  methods: {
    clickMore() {
      //
    }
  }
}
</script>

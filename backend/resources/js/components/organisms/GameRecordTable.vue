<template>
  <div>
    <v-row no-gutters>
      <v-row no-gutters>
        <v-col cols="12">
          <v-card tile class="mb-2">
            <v-row no-gutters>
              <v-col cols="12">
                <v-sheet color="grey lighten-4">
                <v-row no-gutters>
                  <v-col cols="4" class="text-center py-2">マップ</v-col>
                  <v-col cols="4" class="text-center py-2">ゲーム</v-col>
                  <v-col cols="4" class="text-center py-2">ルール</v-col>
                  <v-col cols="4" class="text-center mb-2">グリーンアラビア</v-col>
                  <v-col cols="4" class="text-center mb-2">AoE2DE</v-col>
                  <v-col cols="4" class="text-center mb-2">Esudaルール</v-col>
                </v-row>
                </v-sheet>
              </v-col>
              <v-col cols="6">
                <v-list dense>
                  <v-list-item v-for="item in team1" :key="item.id">
                    <v-list-item-avatar>
                      <Avator :src="item.avator" />
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-title>
                        <v-row no-gutters>
                          <v-col cols="8">{{item.name}}</v-col>
                          <v-col cols="4" class="text-right">{{item.rate}}</v-col>
                        </v-row>
                      </v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                  <v-list-item>
                    <v-list-item-content>
                      <v-list-item-title>
                        <v-divider></v-divider>
                        <v-row no-gutters class="py-2">
                          <v-col cols="8">レート合計</v-col>
                          <v-col cols="4" class="text-right">12000</v-col>
                        </v-row>
                      </v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                </v-list>
              </v-col>
              <v-col cols="6">
                <v-list dense>
                  <v-list-item v-for="item in team2" :key="item.id">
                    <v-list-item-avatar>
                      <Avator :src="item.avator" />
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-title>
                        <v-row no-gutters>
                          <v-col cols="8">{{item.name}}</v-col>
                          <v-col cols="4" class="text-right">{{item.rate}}</v-col>
                        </v-row>
                      </v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                  <v-list-item>
                    <v-list-item-content>
                      <v-list-item-title>
                        <v-divider></v-divider>
                        <v-row no-gutters class="py-2">
                          <v-col cols="8">レート合計</v-col>
                          <v-col cols="4" class="text-right">12000</v-col>
                        </v-row>
                      </v-list-item-title>
                    </v-list-item-content>
                  </v-list-item>
                </v-list>
              </v-col>
            </v-row>
          </v-card>

        </v-col>
      </v-row>
    </v-row>
  </div>
</template>

<style scoped>
.table {
  width: 100%;
}

.table,
.table td,
.table th {
  border: 1px solid #cbced2;
  border-collapse: collapse;
  text-align: center;
}
</style>

<script>
import Avator from '@/components/atoms/Avator'

export default {
  name: 'GameRecordTable',
  components: {
    Avator,
  },
  data() {
    return {
      team1: [
        {name: 'titan', id: 2, rate: 1920, avator: 'https://kai-you.net/images/a/2018/08/189ed781788eb3d56c5bf31655a4195d.jpg'},
        {name: 'nagisa',id: 3,  rate: 2829, avator: 'https://kai-you.net/images/a/2018/08/189ed781788eb3d56c5bf31655a4195d.jpg'},
        {name: 'takeshi', id: 4, rate: 1920, avator: 'https://kai-you.net/images/a/2018/08/189ed781788eb3d56c5bf31655a4195d.jpg'},
        {name: 'yamada', id: 5, rate: 2421, avator: 'https://kai-you.net/images/a/2018/08/189ed781788eb3d56c5bf31655a4195d.jpg'},
      ],
      team2: [
        {name: 'titan', id: 7, rate: 1920, avator: 'https://kai-you.net/images/a/2018/08/189ed781788eb3d56c5bf31655a4195d.jpg'},
        {name: 'nagisa', id: 8, rate: 2829, avator: 'https://kai-you.net/images/a/2018/08/189ed781788eb3d56c5bf31655a4195d.jpg'},
        {name: 'takeshi', id: 9, rate: 1920, avator: 'https://kai-you.net/images/a/2018/08/189ed781788eb3d56c5bf31655a4195d.jpg'},
        {name: 'yamada', id: 10, rate: 2421, avator: 'https://kai-you.net/images/a/2018/08/189ed781788eb3d56c5bf31655a4195d.jpg'},
      ],
    }
  }
}
</script>

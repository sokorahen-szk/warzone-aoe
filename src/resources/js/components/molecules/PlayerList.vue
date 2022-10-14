<template>
    <v-sheet class="overflow-y-auto" max-height="200" outlined>
        <div class="pa-1 text-right">
            <small>検索結果：{{ players.length }} 件</small>
        </div>
        <v-list flat class="pa-0 ma-0" dense>
            <template v-for="(player, index) in players">
                <v-list-item
                    :key="index"
                    @click="click(player)"
                    :class="{
                        'blue-grey lighten-5':
                            selectedList.indexOf(player.id) !== -1
                    }"
                >
                    <v-list-item-avatar>
                        <v-img
                            v-if="player.avatorImage"
                            :src="player.avatorImage"
                        />
                        <v-avatar v-else color="grey lighten-2" size="40" />
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-row no-gutters class="ma-0 pa-0">
                            <v-col cols="6">{{ player.name }}</v-col>
                            <v-col
                                cols="6"
                                class="text-right"
                                v-show="player.mu != null"
                                >レート:{{ player.mu }}</v-col
                            >
                        </v-row>
                    </v-list-item-content>
                </v-list-item>
                <v-divider :key="`divider-${index}`" />
            </template>
        </v-list>
    </v-sheet>
</template>

<script>
import router from "@/router/index";
export default {
    name: "PlayerList",
    props: {
        players: { type: Array, default: [] },
        playerLimit: { type: Number }
    },
    methods: {
        click(player) {
            if (player["link"]) {
                router.push({ path: `player/${player.id}` });
            }

            let isAdded = false;
            const index = this.selectedList.indexOf(player.id);
            if (index !== -1) {
                this.selectedList.splice(index, 1);
            } else {
                isAdded = true;

                if (this.selectedList.length >= this.playerLimit) return;

                this.selectedList.push(player.id);
            }

            return this.$emit("click", {
                player: player,
                isAdded: isAdded
            });
        }
    },
    data() {
        return {
            selectedList: []
        };
    }
};
</script>

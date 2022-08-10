<template>
    <v-card flat>
        <v-card-title>
            レーティング
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="players"
            :items-per-page="perPage"
            :search="playerSearch"
            class="player-table"
            @click:row="onClickEvent"
        >
            <template v-slot:top>
                <v-row no-gutters>
                    <v-col cols="12" sm="6" md="4" lg="3" xl="3">
                        <v-row no-gutters class="pa-4">
                            <v-col cols="12">
                                <small>プレイヤー検索</small>
                            </v-col>
                            <v-col cols="12">
                                <TextInput
                                    :value="playerSearch"
                                    @update="playerSearch = $event"
                                    outlined
                                    flat
                                    required
                                />
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
import TextInput from "@atoms/TextInput";
export default {
    name: "PlayerTable",
    components: {
        TextInput
    },
    props: {
        perPage: { type: Number, default: 10 },
        players: { type: Array, default: [] }
    },
    data() {
        return {
            playerSearch: "",
            headers: [
                {
                    text: "プレイヤー名",
                    align: "start",
                    value: "name"
                },
                { text: "レート", value: "rate" },
                { text: "ランク", value: "rank" },
                { text: "試合数", value: "games" },
                { text: "勝利", value: "win" },
                { text: "敗北", value: "defeat" },
                { text: "引分", value: "draw" },
                { text: "勝率", value: "wp" }
            ]
        };
    },
    methods: {
        onClickEvent(data) {
            this.$router.push(`/player/${data.userId}`);
        }
    }
};
</script>

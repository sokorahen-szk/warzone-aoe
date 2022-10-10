<template>
    <div>
        <v-simple-table dense>
            <template v-slot:default>
                <thead>
                    <tr>
                        <th class="text-center w20">
                            日付
                        </th>
                        <th class="text-center w40">
                            <v-row no-gutters class="py-1">
                                <v-col>チーム1</v-col>
                            </v-row>
                            <v-row no-gutters class="py-1">
                                <v-col cols="2"></v-col>
                                <v-col cols="7" class="py-1 text-left"
                                    >プレイヤー</v-col
                                >
                                <v-col cols="3" class="py-1 text-left"
                                    >レート</v-col
                                >
                            </v-row>
                        </th>
                        <th class="text-center w40">
                            <v-row no-gutters class="py-1">
                                <v-col>チーム2</v-col>
                            </v-row>
                            <v-row no-gutters class="py-1">
                                <v-col cols="2"></v-col>
                                <v-col cols="7" class="py-1 text-left"
                                    >プレイヤー</v-col
                                >
                                <v-col cols="3" class="py-1 text-left"
                                    >レート</v-col
                                >
                            </v-row>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="tr"
                        v-for="gameRecord in gameRecordList"
                        :key="gameRecord.gameId"
                    >
                        <td class="text-center mb-3">
                            <div>{{ gameRecord.gameStartDate }}</div>
                            <div>{{ gameRecord.gameStartTime }}</div>
                            <div>
                                <Label>{{ gameRecord.gamePackage.name }}</Label>
                            </div>
                            <div>
                                {{ gameStatus(gameRecord.status) }}
                            </div>
                        </td>
                        <td>
                            <template
                                v-for="player in gameRecord.playerMemories[1]"
                            >
                                <v-row
                                    no-gutters
                                    class="py-2"
                                    :key="`table-team1-${player.playerId}`"
                                >
                                    <v-col cols="2" class="text-center"
                                        ><Avator :src="player.avatorImage"
                                    /></v-col>
                                    <v-col cols="7" class="py-2">
                                        <Link
                                            :path="`/player/${player.userId}`"
                                            >{{ player.playerName }}</Link
                                        >
                                    </v-col>
                                    <v-col cols="3" class="py-2">
                                        <span v-if="gameRecord.status != 4">
                                            {{ player.mu }}
                                        </span>
                                        <span v-else>
                                            {{ player.mu }} ({{
                                                calc(player.mu, player.afterMu)
                                            }})</span
                                        >
                                    </v-col>
                                </v-row>
                            </template>
                            <v-row
                                no-gutters
                                class="py-2"
                                v-for="i in Math.ceil(
                                    gameRecord.playerCount / 2
                                ) - gameRecord.playerMemories[1].length"
                                :key="`table-tema1-dummy-${i}`"
                            >
                                <v-col cols="12" class="py-2">&nbsp;</v-col>
                            </v-row>
                            <v-divider />
                            <v-row no-gutters class="py-2">
                                <v-col cols="9">
                                    <Label
                                        :color="
                                            status(gameRecord.winningTeam, 1)
                                                ? 'success'
                                                : 'error'
                                        "
                                        v-if="gameRecord.winningTeam"
                                    >
                                        {{
                                            status(gameRecord.winningTeam, 1)
                                                ? "勝ち"
                                                : "負け"
                                        }}
                                    </Label>
                                </v-col>
                                <v-col cols="3" class="py-2">{{
                                    sum(gameRecord.playerMemories[1], "mu")
                                }}</v-col>
                            </v-row>
                        </td>
                        <td>
                            <template
                                v-for="player in gameRecord.playerMemories[2]"
                            >
                                <v-row
                                    no-gutters
                                    class="py-2"
                                    :key="`table-team2-${player.playerId}`"
                                >
                                    <v-col cols="2" class="text-center"
                                        ><Avator :src="player.avatorImage"
                                    /></v-col>
                                    <v-col cols="7" class="py-2">
                                        <Link
                                            :path="`/player/${player.userId}`"
                                            >{{ player.playerName }}</Link
                                        >
                                    </v-col>
                                    <v-col cols="3" class="py-2">
                                        <span v-if="gameRecord.status != 4">
                                            {{ player.mu }}
                                        </span>
                                        <span v-else>
                                            {{ player.mu }} ({{
                                                calc(player.mu, player.afterMu)
                                            }})</span
                                        >
                                    </v-col>
                                </v-row>
                            </template>
                            <v-row
                                no-gutters
                                class="py-2"
                                v-for="i in Math.ceil(
                                    gameRecord.playerCount / 2
                                ) - gameRecord.playerMemories[2].length"
                                :key="`table-tema2-dummy-${i}`"
                            >
                                <v-col cols="12" class="py-2">&nbsp;</v-col>
                            </v-row>
                            <v-divider />
                            <v-row no-gutters class="py-2">
                                <v-col cols="9">
                                    <Label
                                        :color="
                                            status(gameRecord.winningTeam, 2)
                                                ? 'success'
                                                : 'error'
                                        "
                                        v-if="gameRecord.winningTeam"
                                    >
                                        {{
                                            status(gameRecord.winningTeam, 2)
                                                ? "勝ち"
                                                : "負け"
                                        }}
                                    </Label>
                                </v-col>
                                <v-col cols="3" class="py-2">{{
                                    sum(gameRecord.playerMemories[2], "mu")
                                }}</v-col>
                            </v-row>
                        </td>
                    </tr>
                </tbody>
            </template>
        </v-simple-table>
        <Pagination
            :current="currentPage"
            :length="gameRecordTotalPage"
            @change="page => $emit('changePage', page)"
        />
    </div>
</template>

<script>
import Avator from "@atoms/Avator";
import Label from "@atoms/Label";
import Pagination from "@atoms/Pagination";
import Link from "@atoms/Link";
import { gameStatusLabels } from "@/config/game";

export default {
    name: "GameRecordTable",
    components: {
        Avator,
        Label,
        Pagination,
        Link
    },
    props: {
        gameRecordList: Array,
        currentPage: Number,
        gameRecordTotalPage: Number
    },
    methods: {
        sum(d, key) {
            if (!d || !key) {
                return 0;
            }

            return d.reduce(function(s, v) {
                return s + v[key];
            }, 0);
        },
        status(winning, team) {
            return winning == team;
        },
        addSign(num) {
            if (num === null) return "";
            if (num > 0) {
                return `+${Math.abs(num)}`;
            } else if (num < 0) {
                return `-${Math.abs(num)}`;
            }
            return "ー";
        },
        calc(before, after) {
            return this.addSign(after - before);
        },
        gameStatus(status) {
            const gameStatusLabel = gameStatusLabels.find(gameStatusLabel => {
                return gameStatusLabel.id === status;
            });

            return gameStatusLabel && gameStatusLabel.label;
        }
    }
};
</script>

<style scoped>
thead > tr {
    background: rgb(99, 99, 99);
}

thead > tr > th {
    height: 45px !important;
    color: #ddd !important;
}

.w20 {
    width: 20%;
}

.w40 {
    width: 40%;
}

.tr:hover {
    background: transparent !important;
}
</style>

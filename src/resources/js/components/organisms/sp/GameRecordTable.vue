<template>
    <div>
        <v-card tile class="mb-1 thead">
            <v-row no-gutters class="py-1">
                <v-col cols="2"></v-col>
                <v-col cols="5" class="py-1 text-left">プレイヤー</v-col>
                <v-col cols="2" class="py-1 text-left">ランク</v-col>
                <v-col cols="3" class="py-1 text-left">レート</v-col>
            </v-row>
        </v-card>
        <v-card
            v-for="gameRecord in gameRecordList"
            :key="gameRecord.gameId"
            class="mb-5"
        >
            <v-row no-gutters class="py-1 d-flex head-row">
                <v-col cols="8 d-flex align-center justify-center">
                    <span>{{ gameRecord.gameStartDate }}</span
                    >&nbsp;
                    <span>{{ gameRecord.gameStartTime }}</span>
                </v-col>
                <v-col cols="4 d-flex justify-center">
                    <Label :color="'success'">{{
                        gameRecord.gamePackage.name
                    }}</Label>
                </v-col>
            </v-row>
            <v-divider />
            <v-row no-gutters class="py-1">
                <v-col cols="12">
                    <template v-for="player in gameRecord.playerMemories[1]">
                        <v-row
                            no-gutters
                            class="py-2"
                            :key="`table-team1-${player.playerId}`"
                        >
                            <v-col cols="2" class="text-center"
                                ><Avator :src="player.avatorImage"
                            /></v-col>

                            <v-col cols="5" class="py-2">
                                <Link :path="`/player/${player.userId}`">{{
                                    player.playerName
                                }}</Link>
                            </v-col>
                            <v-col cols="2" class="py-2">
                                <span v-if="gameRecord.status != 4">
                                    {{ player.rank }}
                                </span>
                                <span v-else>
                                    {{ player.afterRank }} ({{
                                        calc(player.rank, player.afterRank)
                                    }})</span
                                >
                            </v-col>
                            <v-col cols="3" class="py-2">
                                <span v-if="gameRecord.status != 4">
                                    {{ player.rate }}
                                </span>
                                <span v-else>
                                    {{ player.afterRate }} ({{
                                        calc(player.rate, player.afterRate)
                                    }})</span
                                >
                            </v-col>
                        </v-row>
                    </template>
                    <v-row no-gutters class="py-2">
                        <v-col cols="7">
                            <Label
                                :color="
                                    status(gameRecord.winningTeam, 1)
                                        ? 'primary'
                                        : 'error'
                                "
                                v-if="gameRecord.winningTeam"
                            >
                                {{
                                    status(gameRecord.winningTeam, 1)
                                        ? "WIN"
                                        : "LOSE"
                                }}
                            </Label>
                        </v-col>
                        <v-col cols="2" class="py-2">{{
                            sum(gameRecord.playerMemories[1], "rank")
                        }}</v-col>
                        <v-col cols="2" class="py-2">{{
                            sum(gameRecord.playerMemories[1], "rate")
                        }}</v-col>
                    </v-row>
                    <v-divider />
                </v-col>
                <v-col cols="12">
                    <template v-for="player in gameRecord.playerMemories[2]">
                        <v-row
                            no-gutters
                            class="py-2"
                            :key="`table-team1-${player.playerId}`"
                        >
                            <v-col cols="2" class="text-center"
                                ><Avator :src="player.avatorImage"
                            /></v-col>
                            <v-col cols="5" class="py-2">
                                <Link :path="`/player/${player.userId}`">{{
                                    player.playerName
                                }}</Link>
                            </v-col>
                            <v-col cols="2" class="py-2">
                                <span v-if="gameRecord.status != 4">
                                    {{ player.rank }}
                                </span>
                                <span v-else>
                                    {{ player.afterRank }} ({{
                                        calc(player.rank, player.afterRank)
                                    }})</span
                                >
                            </v-col>
                            <v-col cols="3" class="py-2">
                                <span v-if="gameRecord.status != 4">
                                    {{ player.rate }}
                                </span>
                                <span v-else>
                                    {{ player.afterRate }} ({{
                                        calc(player.rate, player.afterRate)
                                    }})</span
                                >
                            </v-col>
                        </v-row>
                    </template>
                    <v-row no-gutters class="py-2">
                        <v-col cols="7">
                            <Label
                                :color="
                                    status(gameRecord.winningTeam, 2)
                                        ? 'primary'
                                        : 'error'
                                "
                                v-if="gameRecord.winningTeam"
                            >
                                {{
                                    status(gameRecord.winningTeam, 2)
                                        ? "WIN"
                                        : "LOSE"
                                }}
                            </Label>
                        </v-col>
                        <v-col cols="2" class="py-2">{{
                            sum(gameRecord.playerMemories[2], "rank")
                        }}</v-col>
                        <v-col cols="2" class="py-2">{{
                            sum(gameRecord.playerMemories[2], "rate")
                        }}</v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-card>
        <Pagination
            :current="currentPage"
            :length="gameRecordTotalPage"
            @change="page => $emit('pageChange', page)"
        />
    </div>
</template>

<script>
import Avator from "@atoms/Avator";
import Label from "@atoms/Label";
import Pagination from "@atoms/Pagination";
import Link from "@atoms/Link";
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
            return "0";
        },
        calc(before, after) {
            return this.addSign(after - before);
        }
    }
};
</script>

<style scoped>
.thead {
    background: rgb(99, 99, 99);
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

.v-data-table td {
    margin-bottom: 10px;
}

.thead {
    border-radius: none;
    color: rgba(0, 0, 0, 0.6);
}
</style>

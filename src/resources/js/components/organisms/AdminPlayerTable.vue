<template>
    <div>
        <slot name="header"></slot>
        <Loading class="pa-2" size="32" v-if="isLoading" />
        <v-simple-table v-else>
            <template v-slot:default>
                <thead>
                    <tr>
                        <th class="text-left">
                            ID
                        </th>
                        <th class="text-left">
                            プレイヤー名
                        </th>
                        <th class="text-left">
                            ランク
                        </th>
                        <th class="text-left">
                            mu
                        </th>
                        <th class="text-left">
                            sigma
                        </th>
                        <th class="text-left">
                            レート
                        </th>
                        <th class="text-left">
                            ステータス
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="player in players"
                        :key="player.id"
                        @click="$emit('clickShow', player.id)"
                    >
                        <td>{{ player.id }}</td>
                        <td>
                            <v-avatar color="grey lighten-2" size="40">
                                <img :src="player.avatorImage" />
                            </v-avatar>
                            {{ player.name }}
                        </td>
                        <td>{{ player.rank }}</td>
                        <td>{{ player.mu }}</td>
                        <td>{{ player.sigma }}</td>
                        <td>{{ player.rate }}</td>
                        <td>{{ player.enabled ? "有効" : "無効" }}</td>
                    </tr>
                </tbody>
            </template>
        </v-simple-table>
        <Pagination
            :current="currentPage"
            :length="playerRecordTotalPage"
            @change="page => $emit('changePage', page)"
        />
    </div>
</template>

<script>
import Pagination from "@atoms/Pagination";
import Loading from "@atoms/Loading";

export default {
    name: "AdminPlayerTable",
    components: {
        Pagination,
        Loading
    },
    props: {
        players: { type: Array },
        currentPage: { type: Number },
        playerRecordTotalPage: { type: Number }
    },
    data() {
        return {
            isLoading: true
        };
    },
    watch: {
        players: {
            handler(value) {
                this.isLoading = value ? false : true;
            },
            deep: true
        }
    }
};
</script>

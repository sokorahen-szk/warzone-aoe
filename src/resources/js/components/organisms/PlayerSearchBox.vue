<template>
    <div>
        <TextInput
            :value="search"
            @update="search = $event"
            placeholder="プレイヤー名を検索する"
            solo
            flat
            required
            :disabled="players.length < 1"
        />
        <div class="suggestion">
            <PlayerList
                v-show="setPlayers.length > 0"
                :players="setPlayers"
                :player-limit="selectedPlayerLimit"
                :player-count="selectedPlayerCount"
                @click="update"
            />
        </div>
    </div>
</template>

<style scoped>
.suggestion {
    position: relative;
    top: -30px;
}
</style>

<script>
import TextInput from "@atoms/TextInput";
import PlayerList from "@molecules/PlayerList";

export default {
    name: "PlayerSearchBox",
    components: {
        TextInput,
        PlayerList
    },
    props: {
        keyword: { type: String, default: null },
        players: { type: Array, default: [] },
        selectedPlayerLimit: { type: Number },
        selectedPlayerCount: { type: Number }
    },
    data() {
        return {
            search: null
        };
    },
    watch: {
        keyword(v) {
            this.search = v;
        },
        search(v) {
            return this.$emit("input", v);
        }
    },
    computed: {
        setPlayers() {
            if (!this.search) {
                return [];
            }

            return this.players.filter(player => {
                if (player.name === null) {
                    return false;
                }
                return (
                    player.name
                        .toUpperCase()
                        .indexOf(this.search.toUpperCase()) != -1
                );
            });
        }
    },
    methods: {
        update(e) {
            return this.$emit("update", e);
        }
    }
};
</script>

<template>
    <CommonWithRightColumnTemplate outlined :device="getDeviceType">
        <template slot="header">
            <Alert :properties="alert" dense />
        </template>
        <template slot="right">
            <AccountRightMenu :role="profileView.role" />
        </template>
        <template slot="container">
            <v-container>
                <AdminPlayerTable
                    :players="players"
                    :playerRecordTotalPage="getPlayersTotalPage"
                    :current-page="page"
                    @changePage="currentPage => (page = currentPage)"
                    @clickShow="show($event)"
                />

                <Modal
                    title="プレイヤー管理"
                    :show="isEditModal"
                    @update="isEditModal = $event"
                >
                    <v-form ref="form" v-model="valid" lazy-validation>
                        <v-row no-gutters v-if="selectedPlayer">
                            <v-col cols="12" class="py-0 ma-0">
                                <v-row no-gutters>
                                    <v-col cols="12">
                                        <v-row no-gutters>
                                            <v-col cols="6" class="py-0 ma-0">
                                                <div>プレイヤーID</div>
                                                <div class="mb-4">
                                                    {{ selectedPlayer.id }}
                                                </div>
                                            </v-col>
                                            <v-col cols="6" class="py-0 ma-0">
                                                <div>ランク</div>
                                                <div class="mb-4">
                                                    {{ selectedPlayer.rank }}
                                                </div>
                                            </v-col>
                                        </v-row>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-col cols="12" class="py-0 ma-0">
                                            <div class="pb-1">
                                                プレイヤー名<RequireLabel />
                                            </div>
                                            <TextInput
                                                v-model="selectedPlayer.name"
                                                @update="
                                                    selectedPlayer.name = $event
                                                "
                                                placeholder=""
                                                outlined
                                                required
                                                :rules="{
                                                    label: 'プレイヤー名',
                                                    types:
                                                        'required,min:2,max:30'
                                                }"
                                            />
                                        </v-col>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-col cols="12" class="py-0 ma-0">
                                            <div class="pb-1">
                                                Mu<RequireLabel />
                                            </div>
                                            <TextInput
                                                v-model="selectedPlayer.mu"
                                                @update="
                                                    selectedPlayer.mu = $event
                                                "
                                                placeholder=""
                                                outlined
                                                required
                                                :rules="{
                                                    label: 'Mu',
                                                    types: 'required'
                                                }"
                                            />
                                        </v-col>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-col cols="12" class="py-0 ma-0">
                                            <div class="pb-1">
                                                Sigma<RequireLabel />
                                            </div>
                                            <TextInput
                                                v-model="selectedPlayer.mu"
                                                @update="
                                                    selectedPlayer.mu = $event
                                                "
                                                placeholder=""
                                                outlined
                                                required
                                                :rules="{
                                                    label: 'Sigma',
                                                    types: 'required'
                                                }"
                                            />
                                        </v-col>
                                    </v-col>
                                    <v-col cols="12" class="py-0 ma-0">
                                        <v-col cols="12" class="py-0 ma-0">
                                            <div class="pb-1">
                                                レート<RequireLabel />
                                            </div>
                                            <TextInput
                                                v-model="selectedPlayer.rate"
                                                @update="
                                                    selectedPlayer.rate = $event
                                                "
                                                placeholder=""
                                                outlined
                                                required
                                                :rules="{
                                                    label: 'レート',
                                                    types: 'required'
                                                }"
                                            />
                                        </v-col>
                                    </v-col>
                                    <v-col cols="12" class="py-0 ma-0">
                                        <v-col cols="12" class="py-0 ma-0">
                                            <div class="pb-1">
                                                ステータス<RequireLabel />
                                            </div>
                                            <SelectBox
                                                value="1"
                                                :rules="{
                                                    label: 'ステータス',
                                                    types: 'required'
                                                }"
                                                :items="setPlayerStatuses"
                                                :selectedIndex="
                                                    selectedPlayer.enabled
                                                        ? 1
                                                        : 2
                                                "
                                                @input="
                                                    selectedPlayer.enabled = $event
                                                "
                                                :disabled="
                                                    setPlayerStatuses.length < 1
                                                "
                                                placeholder="ステータスを選択する"
                                                required
                                                outlined
                                                dense
                                            />
                                        </v-col>
                                    </v-col>
                                    <v-col cols="12" class="py-3 text-center">
                                        <Button
                                            color="success"
                                            label="保存"
                                            iconType="mdi-content-save"
                                            icon
                                            block
                                            :height="45"
                                            :loading="isLoading"
                                            :disabled="!valid"
                                            @click="update"
                                        />
                                    </v-col>
                                </v-row>
                            </v-col>
                        </v-row>
                    </v-form>
                </Modal>
            </v-container>
        </template>
    </CommonWithRightColumnTemplate>
</template>

<script>
import CommonWithRightColumnTemplate from "@templates/CommonWithRightColumnTemplate";
import AccountRightMenu from "@organisms/AccountRightMenu";
import AdminPlayerTable from "@organisms/AdminPlayerTable";
import Alert from "@atoms/Alert";
import Modal from "@atoms/Modal";
import SelectBox from "@atoms/SelectBox";
import RequireLabel from "@atoms/RequireLabel";
import TextInput from "@atoms/TextInput";
import Button from "@atoms/Button";
import { mapActions, mapGetters } from "vuex";
import { editPlayerByAdminTemplate } from "@/config/admin";
import { objCopy } from "@/services/helper";
import { alertTemplate } from "@/config/global";
import { profileViewTemplate } from "@/config/account";
import { playerStatusLabels } from "@/config/player";

export default {
    name: "Rate",
    components: {
        CommonWithRightColumnTemplate,
        AccountRightMenu,
        Alert,
        AdminPlayerTable,
        Modal,
        RequireLabel,
        TextInput,
        SelectBox,
        Button
    },
    data() {
        return {
            profileView: profileViewTemplate,
            alert: alertTemplate,

            players: null,
            selectedPlayer: Object.assign({}, editPlayerByAdminTemplate),

            playerRecordTotalPage: 0,
            page: 1,

            isEditModal: false,

            valid: true,
            isLoading: false
        };
    },
    watch: {
        page() {
            this.fetchList();
        }
    },
    mounted() {
        this.fetchList();

        this.$store.subscribe(mutation => {
            if (mutation.type === "accountStore/setProfile") {
                this.$set(
                    this,
                    "profileView",
                    objCopy(this.profileView, this.getProfile)
                );
            }
            if (mutation.type === "adminStore/setPlayers") {
                this.$set(this, "players", this.getPlayers);
                this.$set(
                    this,
                    "playerRecordTotalPage",
                    this.getPlayersTotalPage
                );
            }
            this.$set(this, "players", this.getPlayers);
        });
        this.$set(
            this,
            "profileView",
            objCopy(this.profileView, this.getProfile)
        );
    },
    computed: {
        ...mapGetters("accountStore", ["getProfile"]),
        ...mapGetters("breakpointStore", ["getDeviceType"]),
        ...mapGetters("adminStore", ["getPlayers", "getPlayersTotalPage"]),
        setPlayerStatuses() {
            let v = [];
            playerStatusLabels.forEach(item => {
                v.push({
                    label: item.label,
                    value: item.value
                });
            });

            return v;
        }
    },
    methods: {
        ...mapActions("adminStore", ["listPlayer", "updatePlayer"]),
        fetchList() {
            this.players = null;

            new Promise(resolve => {
                resolve(this.listPlayer({ page: this.page }));
            }).catch(err => {
                this.alert = Object.assign(alertTemplate, {
                    show: true,
                    type: "error",
                    message: err
                });
            });
        },
        show(id) {
            const findPlayer = this.findPlayerById(id);

            if (!findPlayer) {
                return;
            }

            this.$set(this, "selectedPlayer", {
                id: findPlayer.id,
                name: findPlayer.name,
                rate: findPlayer.rate,
                rank: findPlayer.rank,
                mu: findPlayer.mu,
                sigma: findPlayer.sigma,
                enabled: findPlayer.enabled
            });

            this.isEditModal = true;
        },
        update() {
            if (!this.$refs.form.validate()) return;

            new Promise(resolve => {
                resolve(
                    this.updatePlayer({
                        id: this.selectedPlayer.id,
                        playerName: this.selectedPlayer.name,
                        mu: this.selectedPlayer.mu,
                        sigma: this.selectedPlayer.sigma,
                        rate: this.selectedPlayer.rate,
                        enabled: this.selectedPlayer.enabled ? 1 : 0
                    })
                );
            })
                .then(res => {
                    this.alert = {
                        show: true,
                        type: "info",
                        message: res
                    };
                })
                .catch(err => {
                    this.alert = {
                        show: true,
                        type: "error",
                        message: err
                    };
                })
                .finally(() => {
                    this.isEditModal = false;
                    this.isLoading = false;

                    this.fetchList();

                    this.selectedPlayer = Object.assign(
                        {},
                        editPlayerByAdminTemplate
                    );
                });
        },
        findPlayerById(id) {
            return this.players.find(user => user.id === id);
        }
    }
};
</script>

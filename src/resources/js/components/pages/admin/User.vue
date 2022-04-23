<template>
    <CommonWithRightColumnTemplate outlined :device="getDeviceType">
        <template slot="header">
            <Alert :properties="alert" dense />
        </template>
        <template slot="right">
            <AccountRightMenu :role="profileView.role" />
        </template>
        <template slot="container">
            <UserTable
                :users="users"
                :userRecordTotalPage="getUsersTotalPage"
                :current-page="page"
                @changePage="currentPage => (page = currentPage)"
                @clickShow="show(editTypes.edit, $event)"
            >
                <template v-slot:header>
                    <v-row no-gutters>
                        <v-col class="text-right">
                            <Button
                                color="success"
                                label="新規登録"
                                @click="show(editTypes.create)"
                            />
                        </v-col>
                    </v-row>
                </template>
            </UserTable>

            <Modal
                title="ユーザ管理"
                :show="isEditModal"
                @update="isEditModal = $event"
            >
                <v-form ref="form" v-model="valid" lazy-validation>
                    <v-row
                        no-gutters
                        v-if="
                            selectedUser.id ||
                                selectedEditType === editTypes.create
                        "
                    >
                        <v-col cols="12" class="py-0 ma-0">
                            <v-row
                                no-gutters
                                v-if="selectedEditType === editTypes.edit"
                            >
                                <v-col cols="6">
                                    <v-col cols="12" class="py-0 ma-0">
                                        <div>ユーザID</div>
                                        <div class="mb-4">
                                            {{ selectedUser.id }}
                                        </div>
                                    </v-col>
                                    <v-col cols="12" class="py-0 ma-0">
                                        <div>アカウント作成日</div>
                                        <div class="mb-4">
                                            {{ selectedUser.joinedAt }}
                                        </div>
                                    </v-col>
                                    <v-col cols="12" class="py-0 ma-0">
                                        <div>最終ゲーム参加日</div>
                                        <div class="mb-4">
                                            {{ selectedUser.lastGameAt }}
                                        </div>
                                    </v-col>
                                </v-col>
                                <v-col cols="6" class="text-center">
                                    <Avator
                                        size="200"
                                        :src="selectedUser.avatorImage"
                                    />
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-col cols="12" class="py-0 ma-0">
                            <div class="pb-1">ユーザ名<RequireLabel /></div>
                            <TextInput
                                v-model="selectedUser.name"
                                @update="selectedUser.name = $event"
                                placeholder=""
                                outlined
                                required
                                :rules="{
                                    label: 'ユーザ名',
                                    types: 'required,min:4,max:10'
                                }"
                            />
                        </v-col>
                        <v-col
                            cols="12"
                            class="py-0 ma-0"
                            v-if="selectedEditType === editTypes.create"
                        >
                            <div class="pb-1">プレイヤー名<RequireLabel /></div>
                            <TextInput
                                v-model="selectedUser.playerName"
                                @update="selectedUser.playerName = $event"
                                placeholder=""
                                outlined
                                required
                                :rules="{
                                    label: 'プレイヤー名',
                                    types: 'required,min:2,max:30'
                                }"
                            />
                        </v-col>
                        <v-col
                            cols="12"
                            class="py-0 ma-0"
                            v-if="selectedEditType === editTypes.edit"
                        >
                            <div class="pb-1">メールアドレス</div>
                            <TextInput
                                v-model="selectedUser.email"
                                @update="selectedUser.email = $event"
                                placeholder=""
                                outlined
                                required
                                :rules="{ label: 'email', types: '' }"
                            />
                        </v-col>
                        <v-col
                            cols="12"
                            class="py-0 mb-4"
                            v-show="!isEditPassword"
                        >
                            <div class="pb-1">パスワード</div>
                            <Button
                                label="パスワードを変更する"
                                color="info"
                                tile
                                @click="isEditPassword = !isEditPassword"
                            />
                        </v-col>
                        <v-col
                            cols="12"
                            class="py-0 mb-0"
                            v-show="isEditPassword"
                        >
                            <div class="pb-1">パスワード<RequireLabel /></div>
                            <PasswordTextInput
                                v-if="isEditPassword"
                                v-model="selectedUser.password"
                                @update="selectedUser.password = $event"
                                placeholder="password"
                                outlined
                                required
                                :rules="{
                                    label: 'パスワード',
                                    types: 'required,min:8'
                                }"
                            />
                        </v-col>
                        <v-col
                            cols="12"
                            class="py-0 ma-0"
                            v-if="selectedEditType === editTypes.edit"
                        >
                            <div class="pb-1">ステータス<RequireLabel /></div>
                            <SelectBox
                                value="1"
                                :rules="{
                                    label: 'ステータス',
                                    types: 'required'
                                }"
                                :items="setUserStatuses"
                                :selectedIndex="selectedUser.status"
                                @input="selectedUser.status = $event"
                                :disabled="setUserStatuses.length < 1"
                                placeholder="ステータスを選択する"
                                required
                                outlined
                                dense
                            />
                        </v-col>
                        <v-col cols="12" class="py-0 ma-0">
                            <div class="pb-1">ロール<RequireLabel /></div>
                            <SelectBox
                                value="1"
                                :rules="{ label: 'ロール', types: 'required' }"
                                :items="setRoles"
                                :selectedIndex="selectedUser.roleId"
                                @input="selectedUser.roleId = $event"
                                :disabled="setRoles.length < 1"
                                placeholder="ロールを選択する"
                                required
                                outlined
                                dense
                            />
                        </v-col>
                        <v-col cols="12" class="py-0 ma-0">
                            <div class="pb-1">SteamID</div>
                            <TextInput
                                v-model="selectedUser.steamId"
                                @update="selectedUser.steamId = $event"
                                placeholder=""
                                outlined
                                required
                                :rules="{ label: 'steamID', types: '' }"
                            />
                        </v-col>
                        <v-col
                            cols="12"
                            class="py-0 ma-0"
                            v-if="selectedEditType === editTypes.edit"
                        >
                            <div class="pb-1">Twitter</div>
                            <TextInput
                                v-model="selectedUser.twitterId"
                                @update="selectedUser.twitterId = $event"
                                placeholder=""
                                outlined
                                required
                                :rules="{ label: 'twitterId', types: '' }"
                            />
                        </v-col>
                        <v-col
                            cols="12"
                            class="py-0 ma-0"
                            v-if="selectedEditType === editTypes.edit"
                        >
                            <div class="pb-1">Webサイト</div>
                            <TextInput
                                v-model="selectedUser.webSiteUrl"
                                @update="selectedUser.webSiteUrl = $event"
                                placeholder=""
                                outlined
                                required
                                :rules="{ label: 'Webサイト', types: '' }"
                            />
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
                                @click="update"
                            />
                        </v-col>
                    </v-row>
                </v-form>
            </Modal>
        </template>
    </CommonWithRightColumnTemplate>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import CommonWithRightColumnTemplate from "@templates/CommonWithRightColumnTemplate";
import AccountRightMenu from "@organisms/AccountRightMenu";
import UserTable from "@organisms/UserTable";
import Alert from "@atoms/Alert";
import Button from "@atoms/Button";
import Modal from "@atoms/Modal";
import TextInput from "@atoms/TextInput";
import SelectBox from "@atoms/SelectBox";
import Avator from "@atoms/Avator";
import RequireLabel from "@atoms/RequireLabel";
import PasswordTextInput from "@atoms/PasswordTextInput";
import { profileViewTemplate } from "@/config/account";
import { alertTemplate } from "@/config/global";
import { editUserByAdminTemplate, editUserTypes } from "@/config/admin";
import { objCopy } from "@/services/helper";
import { userStatusLabels } from "@/config/user";
import { roles } from "@/config/admin";
import { toString } from "@/services/api_helper";

export default {
    name: "User",
    components: {
        CommonWithRightColumnTemplate,
        AccountRightMenu,
        UserTable,
        Alert,
        Button,
        Modal,
        TextInput,
        SelectBox,
        Avator,
        RequireLabel,
        PasswordTextInput
    },
    computed: {
        ...mapGetters("accountStore", ["getProfile"]),
        ...mapGetters("breakpointStore", ["getDeviceType"]),
        ...mapGetters("adminStore", ["getUsers", "getUsersTotalPage"]),

        setUserStatuses() {
            let v = [];
            userStatusLabels.forEach(item => {
                v.push({
                    label: item.label,
                    value: item.id
                });
            });

            return v;
        },
        setRoles() {
            let v = [];
            roles.forEach(item => {
                v.push({
                    label: item.label,
                    value: item.id
                });
            });

            return v;
        }
    },
    data() {
        return {
            profileView: profileViewTemplate,
            users: null,
            selectedUser: Object.assign({}, editUserByAdminTemplate),
            alert: alertTemplate,
            page: 1,

            editTypes: editUserTypes,
            selectedEditType: null,

            isEditModal: false,
            isEditPassword: false,
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
            if (mutation.type === "adminStore/setUsers") {
                this.$set(this, "users", this.getUsers);
            }
        });
        this.$set(this, "users", this.getUsers);
        this.$set(
            this,
            "profileView",
            objCopy(this.profileView, this.getProfile)
        );
    },
    methods: {
        ...mapActions("adminStore", ["listUser", "createUser", "updateUser"]),
        fetchList() {
            this.users = null;

            new Promise(resolve => {
                resolve(this.listUser({ page: this.page }));
            }).catch(err => {
                this.alert = Object.assign(alertTemplate, {
                    show: true,
                    type: "error",
                    message: err
                });
            });
        },
        show(editType, id) {
            if (this.editTypes.create == editType) {
                this.$set(
                    this,
                    "selectedUser",
                    Object.assign({}, editUserByAdminTemplate)
                );

                this.isEditPassword = true;
            }
            if (this.editTypes.edit == editType) {
                const findUser = this.findUserById(id);

                if (!findUser) {
                    return;
                }

                this.$set(this, "selectedUser", {
                    id: findUser.id,
                    name: findUser.name,
                    playerName: null,
                    password: null,
                    email: findUser.email,
                    steamId: findUser.steamId,
                    twitterId: findUser.twitterId,
                    webSiteUrl: findUser.webSiteUrl,
                    status: findUser.status,
                    roleId: findUser.role.id,
                    gamePackages: findUser.player.gamePackages,
                    joinedAt: findUser.player.joinedAt,
                    lastGameAt: findUser.player.lastGameAt,
                    avatorImage: findUser.avatorImage
                });

                this.isEditPassword = false;
            }
            this.selectedEditType = editType;
            this.isEditModal = true;
        },
        update() {
            if (!this.$refs.form.validate()) return;

            this.isLoading = true;

            if (this.editTypes.create == this.selectedEditType) {
                new Promise(resolve => {
                    resolve(
                        this.createUser({
                            userName: this.selectedUser.name,
                            playerName: this.selectedUser.playerName,
                            roleId: this.selectedUser.roleId,
                            password: this.selectedUser.password,
                            steamId: this.selectedUser.steamId
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

                        this.selectedUser = Object.assign(
                            {},
                            editUserByAdminTemplate
                        );
                    });
            }
            if (this.editTypes.edit == this.selectedEditType) {
                new Promise(resolve => {
                    resolve(
                        this.updateUser({
                            id: this.selectedUser.id,
                            userName: this.selectedUser.name,
                            password: this.selectedUser.password,
                            email: this.selectedUser.email,
                            steamId: this.selectedUser.steamId,
                            twitterId: this.selectedUser.twitterId,
                            webSiteUrl: this.selectedUser.webSiteUrl,
                            status: this.selectedUser.status,
                            roleId: this.selectedUser.roleId,
                            gamePackages: toString(
                                this.selectedUser.gamePackages
                            )
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

                        this.selectedUser = Object.assign(
                            {},
                            editUserByAdminTemplate
                        );
                    });
            }
        },
        findUserById(id) {
            return this.users.find(user => user.id === id);
        }
    }
};
</script>

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
                />
            </v-container>
        </template>
    </CommonWithRightColumnTemplate>
</template>

<script>
import CommonWithRightColumnTemplate from "@templates/CommonWithRightColumnTemplate";
import AccountRightMenu from "@organisms/AccountRightMenu";
import AdminPlayerTable from "@organisms/AdminPlayerTable";
import Alert from "@atoms/Alert";
import { mapActions, mapGetters } from "vuex";
import { objCopy } from "@/services/helper";
import { alertTemplate } from "@/config/global";
import { profileViewTemplate } from "@/config/account";

export default {
    name: "Rate",
    components: {
        CommonWithRightColumnTemplate,
        AccountRightMenu,
        Alert,
        AdminPlayerTable
    },
    data() {
        return {
            profileView: profileViewTemplate,
            alert: alertTemplate,

            players: null,

            playerRecordTotalPage: 0,
            page: 1
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
        ...mapGetters("adminStore", ["getPlayers", "getPlayersTotalPage"])
    },
    methods: {
        ...mapActions("adminStore", ["listPlayer"]),
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
        }
    }
};
</script>

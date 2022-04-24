import Vue from "vue";
import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";

// Vuex modules...
import breakpointStore from "@/store/breakpoint";
import authStore from "@/store/auth";
import accountStore from "@/store/account";
import playerStore from "@/store/player";
import gameStore from "@/store/game";
import adminStore from "@/store/admin";
import warStore from "@/store/war";

Vue.use(Vuex);

const store = new Vuex.Store({
    modules: {
        breakpointStore: breakpointStore,
        authStore: authStore,
        accountStore: accountStore,
        playerStore: playerStore,
        gameStore: gameStore,
        adminStore: adminStore,
        warStore: warStore
    },
    plugins: [
        createPersistedState({
            key: "wzn",

            paths: ["authStore.token", "accountStore.user"],

            storage: window.localStorage
        })
    ]
});

export default store;

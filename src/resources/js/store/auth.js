const state = {
    token: null
};
const getters = {
    isLogin(state) {
        return !!state.token;
    }
};
const mutations = {
    login(state, payload) {
        state.token = payload.token;
    },
    logout(state) {
        state.token = null;
    }
};
const actions = {
    login({ commit, dispatch }, payload) {
        return new Promise((resolve, reject) => {
            axios
                .post("/api/auth/login", {
                    name: payload.name,
                    password: payload.password
                })
                .then(res => {
                    if (res.data && res.data.isSuccess) {
                        axios.defaults.headers.common[
                            "Authorization"
                        ] = `Bearer ${res.data.body.token}`;
                        commit("login", { token: res.data.body.token });

                        // ユーザ情報取得
                        dispatch("accountStore/profile", null, { root: true });

                        resolve();
                    } else {
                        reject(res.data.errorMessages);
                    }
                });
        });
    },
    logout({ commit, dispatch }) {
        return new Promise(resolve => {
            axios.post("/api/auth/logout").then(res => {
                if (res.data) {
                    commit("logout");

                    // accountStoreリセット
                    dispatch("accountStore/stateReset", null, { root: true });
                    resolve();
                }
            });
        });
    },

    stateReset({ commit }) {
        commit("logout");
    }
};
const authStore = {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
export default authStore;

window._ = require("lodash");
window.axios = require("axios");

window.axios.defaults.headers.common = {
    "X-Requested-With": "XMLHttpRequest",
    "X-CSRF-TOKEN": document.head.querySelector('meta[name="csrf-token"]')
};

let apiAccessToken = null;
if (window.localStorage["wzn"]) {
    const storage = JSON.parse(window.localStorage["wzn"]);
    if (storage) {
        apiAccessToken = storage.authStore.token;
    }

    if (apiAccessToken) {
        window.axios.defaults.headers.common[
            "Authorization"
        ] = `Bearer ${apiAccessToken}`;
    }
}

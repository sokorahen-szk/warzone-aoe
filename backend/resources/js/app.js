import Vue from 'vue'
import Vuetify from 'vuetify';

// Import CSS
import 'vuetify/dist/vuetify.min.css';
import '@mdi/font/css/materialdesignicons.css'

import '@/bootstrap';

import router from '@/router/index';
import store from '@/store/index';

// Main Component
import App from '@/components/App.vue';

Vue.use(Vuetify);

new Vue({
    vuetify: new Vuetify(),
    router,
    store,
    render: h => h(App)
}).$mount('#app');
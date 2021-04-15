import Vue from 'vue'
import Vuetify from 'vuetify';

import 'vuetify/dist/vuetify.min.css';
import '@/bootstrap';

import router from '@/routers/index';

import App from '@/components/App.vue';

Vue.use(Vuetify);

new Vue({
    vuetify: new Vuetify(),
    router,
    render: h => h(App)
}).$mount('#app');
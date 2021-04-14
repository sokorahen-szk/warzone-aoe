import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import './bootstrap';

Vue.use(Vuetify);

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify()
});
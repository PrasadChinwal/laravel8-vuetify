import Vue from 'vue';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-loader

window.axios = require('axios');
window.Vue = require('vue');
Vue.config.productionTip = false;

require('./bootstrap');

Vue.use(Vuetify);

const opts = {};

Vue.component('user-index', require('./pages/user/Index.vue').default);

const app = new Vue({
    el: '#app',
    icons: {
        iconfont: 'mdi',
    },
    vuetify: new Vuetify(opts),
});
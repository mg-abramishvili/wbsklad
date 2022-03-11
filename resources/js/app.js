// require('./bootstrap');

import Vue from 'vue'

window.moment = require('moment');
import moment from 'moment'

Vue.prototype.$moment = moment;
moment.locale('ru');

import axios from 'axios'
window.axios = require('axios');
//window.axios.defaults.withCredentials = true;

import App from './App.vue';
import VueRouter from 'vue-router';
import {routes} from './routes';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: routes,
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
    }
});

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
});
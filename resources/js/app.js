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

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);

Vue.use(VueRouter);

Vue.filter('currency', function (value) {
    if (!value) return '0'
    return parseInt(value).toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + ' ₽' 
})

const router = new VueRouter({
    mode: 'history',
    routes: routes,
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
    }
});

const app = new Vue({
    el: '#wrapper',
    router: router,
    render: h => h(App),
});
import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router'
import router from './router/Index'
import store from './store/Index'

// axios
import axios from 'axios'
window.axios = require('axios')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

// moment.js
import moment from 'moment'
window.moment = require('moment')
Vue.prototype.$moment = moment
moment.locale('ru')

// sweetalerts
import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'
Vue.use(VueSweetalert2)

// multiselect
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.min.css'
Vue.component('multiselect', Multiselect)

// global filters
Vue.filter('currency', function (value) {
    if (!value) return '0'
    return parseInt(value).toFixed(0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + ' ₽' 
})
Vue.filter('date', function (value) {
    if (!value) return ''
    return moment.utc(value).utcOffset(3).format('DD.MM.YYYY')
})

Vue.use(VueRouter)

new Vue({
    render: h => h(App),
    el: '#wrapper',
    router,
    store
});
import Home from './components/Home.vue';

import Login from './components/auth/Login.vue';
import Registration from './components/auth/Registration.vue';

import Settings from './components/settings/Index.vue';

import Warehouse from './components/warehouse/Index.vue';

export const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/registration',
        name: 'Registration',
        component: Registration
    },
    {
        path: '/warehouse',
        name: 'Warehouse',
        component: Warehouse
    },
    {
        path: '/settings',
        name: 'Settings',
        component: Settings
    },
];
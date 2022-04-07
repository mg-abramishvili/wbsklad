import Home from './components/Home.vue';

import Login from './components/auth/Login.vue';
import Registration from './components/auth/Registration.vue';

import Settings from './components/settings/Index.vue';

import Catalog from './components/catalog/Index.vue';

import Nomenclatures from './components/nomenclatures/Index.vue';

import Contractors from './components/contractors/Index.vue';

import UserVerify from './components/users/Verify.vue';

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
        path: '/catalog',
        name: 'Catalog',
        component: Catalog
    },
    {
        path: '/nomenclatures',
        name: 'Nomenclatures',
        component: Nomenclatures
    },
    {
        path: '/contractors',
        name: 'Contractors',
        component: Contractors
    },
    {
        path: '/settings',
        name: 'Settings',
        component: Settings
    },
    {
        path: '/user-verify/:key',
        name: 'UserVerify',
        component: UserVerify
    },
];
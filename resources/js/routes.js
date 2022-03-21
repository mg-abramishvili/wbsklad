import Home from './components/Home.vue';

import Warehouse from './components/warehouse/Index.vue';

export const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/warehouse',
        name: 'Warehouse',
        component: Warehouse
    },
];
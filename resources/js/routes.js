import Home from './components/Home.vue';

import Reports from './components/reports/Index.vue';

export const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/reports',
        name: 'Reports',
        component: Reports
    },
];
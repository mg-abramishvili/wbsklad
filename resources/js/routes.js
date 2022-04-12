import Home from './components/Home.vue';

import Login from './components/auth/Login.vue';
import Registration from './components/auth/Registration.vue';

import Settings from './components/settings/Index.vue';

import Catalog from './components/catalog/Index.vue';

import Nomenclatures from './components/nomenclatures/Index.vue';
import Nomenclature from './components/nomenclatures/Nomenclature.vue';
import NomenclatureCreate from './components/nomenclatures/Create.vue';
import NomenclaturesImport from './components/nomenclatures/Import.vue';

import Contractors from './components/contractors/Index.vue';
import ContractorCreate from './components/contractors/Create.vue';
import Contractor from './components/contractors/Contractor.vue';

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
        path: '/nomenclature/:uid',
        name: 'Nomenclature',
        component: Nomenclature
    },
    {
        path: '/nomenclatures/create',
        name: 'NomenclatureCreate',
        component: NomenclatureCreate
    },
    {
        path: '/nomenclatures/import',
        name: 'NomenclaturesImport',
        component: NomenclaturesImport
    },
    {
        path: '/contractors',
        name: 'Contractors',
        component: Contractors
    },
    {
        path: '/contractors/create',
        name: 'ContractorCreate',
        component: ContractorCreate
    },
    {
        path: '/contractor/:id',
        name: 'Contractor',
        component: Contractor
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
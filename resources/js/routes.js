import Home from './components/Home.vue';

import Login from './components/auth/Login.vue';
import Registration from './components/auth/Registration.vue';

import Settings from './components/settings/Index.vue';

import Products from './components/products/Index.vue';
import Product from './components/products/Product.vue';

import Nomenclatures from './components/nomenclatures/Index.vue';
import Nomenclature from './components/nomenclatures/Nomenclature.vue';
import NomenclatureCreate from './components/nomenclatures/Create.vue';
import NomenclaturesImport from './components/nomenclatures/Import.vue';

import Contractors from './components/contractors/Index.vue';
import ContractorCreate from './components/contractors/Create.vue';
import Contractor from './components/contractors/Contractor.vue';

import StockBalances from './components/stockbalances/Index.vue';
import StockBalanceCreate from './components/stockbalances/Create.vue';
import StockBalance from './components/stockbalances/StockBalance.vue';

import Services from './components/services/Index.vue';
import ServiceCreate from './components/services/Create.vue';
import Service from './components/services/Service.vue';

import RealizationReports from './components/realizationreports/Index.vue';
import RealizationReport from './components/realizationreports/Report.vue';

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
        path: '/products',
        name: 'Products',
        component: Products
    },
    {
        path: '/product/:id',
        name: 'Product',
        component: Product
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
        path: '/contractor/:uid',
        name: 'Contractor',
        component: Contractor
    },
    {
        path: '/stockbalances',
        name: 'StockBalances',
        component: StockBalances
    },
    {
        path: '/stockbalances/create',
        name: 'StockBalanceCreate',
        component: StockBalanceCreate
    },
    {
        path: '/stockbalance/:uid',
        name: 'StockBalance',
        component: StockBalance
    },
    {
        path: '/services',
        name: 'Services',
        component: Services
    },
    {
        path: '/services/create',
        name: 'ServiceCreate',
        component: ServiceCreate
    },
    {
        path: '/service/:uid',
        name: 'Service',
        component: Service
    },
    {
        path: '/realization-reports',
        name: 'RealizationReports',
        component: RealizationReports
    },
    {
        path: '/realization-report/:id',
        name: 'RealizationReport',
        component: RealizationReport
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
<template>
    <div class="stockbalances-page">
        <div class="row mb-4 align-items-center">
            <div class="col-12 col-lg-12">
                <div class="text-right">
                    <router-link :to="{name: 'ServiceCreate'}" class="btn btn-primary">Добавить услугу</router-link>
                </div>
            </div>
        </div>

        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="table-wrapper">
            <ag-grid-vue v-if="services.length"
                class="ag-theme-alpine services-table"
                :defaultColDef="table.defaultColDef"
                :columnDefs="table.columns"
                @grid-ready="onGridReady"
                :rowData="services"
                @row-double-clicked="onRowClicked"
            >
            </ag-grid-vue>

            <p v-else class="text-muted">Нет услуг.</p>
        </div>
    </div>
</template>

<script>
import Loader from '../Loader.vue'

import { AgGridVue } from "ag-grid-vue";
import "ag-grid-community/dist/styles/ag-grid.css";
import "ag-grid-community/dist/styles/ag-theme-alpine.css";

export default {
    data() {
        return {
            services: [],

            table: {
                data: [],
                columns: [
                    { field: "date", headerName: 'Дата', valueFormatter: this.dateFormatter },
                    { field: "contractor", valueGetter: (params) => { return params.data.contractor.name }, headerName: 'Контрагент' },
                ],
                defaultColDef: {
                    movable: false,
                    suppressMovable: true,
                    suppressRowClickSelection: true,
                },
            },

            views: {
                loading: true,
            },
        }
    },
    created() {
        this.$parent.views.title = 'Услуги'

        this.loadServices()
    },
    methods: {
        loadServices() {
            let user = this.$parent.user

            if(!user) {
                return
            }

            axios.get(`/api/services`, { params: { user: user.uid } })
            .then(response => {
                this.services = response.data.data
                this.views.loading = false
            })
            .catch(error => {
                this.$swal({
                    text: error,
                    icon: 'error',
                })
            })
        },
        onGridReady(params) {
            this.gridApi = params.api
            this.gridColumnApi = params.gridColumnApi
            
            this.gridApi.sizeColumnsToFit()
        },
        onRowClicked(event) {
            // this.$router.push({name: 'StockBalance', params: {uid: event.data.uid}})
        },
        currencyFormatter(params) {
            return this.$options.filters.currency(params.value);
        },
        dateFormatter(params) {
            return this.$options.filters.date(params.value);
        },
    },
    components: {
        Loader,
        AgGridVue
    }
}
</script>
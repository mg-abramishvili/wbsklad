<template>
    <div class="stockbalances-page">
        <div class="row mb-4 align-items-center">
            <div class="col-12 col-lg-12">
                <div class="text-right">
                    <router-link :to="{name: 'StockBalanceCreate'}" class="btn btn-primary">Добавить поступление</router-link>
                </div>
            </div>
        </div>

        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="table-wrapper">
            <ag-grid-vue v-if="stockbalances.length"
                class="ag-theme-alpine stockbalances-table"
                :defaultColDef="table.defaultColDef"
                :columnDefs="table.columns"
                @grid-ready="onGridReady"
                :rowData="table.data"
                @row-double-clicked="onRowClicked"
            >
            </ag-grid-vue>

            <p v-else class="text-muted">Нет поступлений.</p>
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
            stockbalances: [],

            table: {
                data: [],
                columns: [
                    { field: "date", headerName: 'Дата поступления', valueFormatter: this.dateFormatter },
                    { field: "contractor", valueGetter: (params) => { return params.data.contractor.name }, headerName: 'Контрагент' },
                    { field: "quantity", valueGetter: (params) => { return params.data.stock_balance_items_count }, headerName: 'Кол-во позиций' },
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
        this.$parent.views.title = 'Поступления'

        this.loadStockBalances()
    },
    methods: {
        loadStockBalances() {
            let user = this.$parent.user

            if(!user) {
                return
            }

            axios.get(`/api/stockbalances`, { params: { user: user.uid } })
            .then(response => {
                this.stockbalances = response.data
                this.table.data = this.stockbalances
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
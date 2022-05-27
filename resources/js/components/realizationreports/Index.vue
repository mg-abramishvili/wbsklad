<template>
    <div class="realizationreports-page">
        <div class="row mb-4 align-items-center">
            <div class="col-12 col-lg-5">
                <input type="text" placeholder="Поиск по отчетам" class="form-control">
            </div>
            <div class="col-12 col-lg-7">
                <div class="text-right">
                    <a @click="importReports()" class="btn btn-primary">Загрузить отчеты</a>
                </div>
            </div>
        </div>

        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="table-wrapper">
            <ag-grid-vue v-if="realizationReports.length"
                class="ag-theme-alpine realizationreports-table"
                :defaultColDef="table.defaultColDef"
                :columnDefs="table.columns"
                @grid-ready="onGridReady"
                :rowData="table.data"
                @row-double-clicked="onRowClicked"
                enableCellTextSelection="true"
                ensureDomOrder="true"
            >
            </ag-grid-vue>

            <p v-else class="text-muted">Нет отчетов.</p>
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
            realizationReports: [],

            table: {
                data: [],
                columns: [
                    { field: "id", headerName: 'Номер отчета', width: 500 },
                    { field: "start_date", headerName: 'Дата начала' },
                    { field: "end_date", headerName: 'Дата конца' },
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
        this.$parent.views.title = 'Отчеты по реализации'

        this.loadRealizationReports()
    },
    methods: {
        loadRealizationReports() {
            let user = this.$parent.user

            if(!user) {
                return
            }

            axios.get(`/api/realization-reports`, { params: { user: user.uid } })
            .then(response => {
                this.realizationReports = response.data
                this.table.data = this.realizationReports
                this.views.loading = false
            })
            .catch(error => {
                this.$swal({
                    text: error,
                    icon: 'error',
                })
            })
        },
        importReports() {
            let user = this.$parent.user

            if(!user) {
                return
            }
            if(!user.settings.wb_api_key) {
                return this.$swal({
                    text: 'Не установлен API-ключ',
                    icon: 'error',
                })
            }

            this.views.loading - true

            axios.get(`/api/realization-reports-import`, { params: { user: user.uid } })
            .then(response => {
                this.loadRealizationReports()
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
            this.$router.push({name: 'RealizationReport', params: {id: event.data.id}})
        },
    },
    components: {
        Loader,
        AgGridVue
    }
}
</script>
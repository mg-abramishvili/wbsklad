<template>
    <div class="contractors-page">
        <div class="row mb-4 align-items-center">
            <div class="col-12 col-lg-5">
                <input type="text" placeholder="Поиск по контрагентам" class="form-control">
            </div>
            <div class="col-12 col-lg-7">
                <div class="text-right">
                    <router-link :to="{name: 'ContractorCreate'}" class="btn btn-primary">Добавить</router-link>
                </div>
            </div>
        </div>

        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="table-wrapper">
            <ag-grid-vue v-if="contractors.length"
                class="ag-theme-alpine contractors-table"
                :defaultColDef="table.defaultColDef"
                :columnDefs="table.columns"
                @grid-ready="onGridReady"
                :rowData="table.data"
                @row-double-clicked="onRowClicked"
                enableCellTextSelection="true"
                ensureDomOrder="true"
            >
            </ag-grid-vue>

            <p v-else class="text-muted">Нет контрагентов.</p>
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
            contractors: [],

            table: {
                data: [],
                columns: [
                    { field: "name", headerName: 'Название', width: 500 },
                    { field: "inn", headerName: 'ИНН' },
                    { field: "tel", headerName: 'Телефон' },
                    { field: "email", headerName: 'E-mail' },
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
        this.$parent.views.title = 'Контрагенты'

        this.loadContractors()
    },
    methods: {
        loadContractors() {
            let user = this.$parent.user

            if(!user) {
                return
            }

            axios.get(`/api/contractors`, { params: { user: user.uid } })
            .then(response => {
                this.contractors = response.data
                this.table.data = this.contractors
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
            this.$router.push({name: 'Contractor', params: {uid: event.data.uid}})
        },
    },
    components: {
        Loader,
        AgGridVue
    }
}
</script>
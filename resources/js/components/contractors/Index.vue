<template>
    <div>
        <div class="prices-list">
            <div class="top-block flex">
                <p>Контрагенты</p>
                <div class="buttons">
                    <router-link :to="{name: 'ContractorCreate'}">Добавить</router-link>
                </div>
            </div>

            <Loader v-if="views.loading" />

            <div v-if="!views.loading" class="table-wrapper">
                <ag-grid-vue v-if="contractors.length"
                    class="ag-theme-alpine contractors-table"
                    :defaultColDef="table.defaultColDef"
                    :columnDefs="userColumns"
                    :rowData="table.data"
                    @row-double-clicked="onRowClicked"
                >
                </ag-grid-vue>

                <p v-else>Нет контрагентов.</p>
            </div>
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
                userColumns: [],
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
    computed: {
        userColumns() {
            if(this.table.userColumns && this.table.userColumns.length) {
                return this.table.userColumns
            }
        },
    },
    created() {
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
                this.views.loading = false,
                this.loadTable()
            })
            .catch(error => {
                this.$swal({
                    text: error,
                    icon: 'error',
                })
            })
        },
        loadTable() {
            this.table.userColumns = [
                { field: "name", headerName: 'Название', width: 500 },
                { field: "inn", headerName: 'ИНН' },
                { field: "tel", headerName: 'Телефон' },
                { field: "email", headerName: 'E-mail' },
            ]
                
            this.table.data = this.contractors
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
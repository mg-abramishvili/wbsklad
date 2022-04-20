<template>
    <div class="nomenclatures-page">
        <div class="row mb-4 align-items-center">
            <div class="col-12 col-lg-5">
                <input type="text" placeholder="Поиск по номенклатуре" class="form-control">
            </div>
            <div class="col-12 col-lg-7">
                <div class="text-right">
                    <router-link :to="{name: 'NomenclatureCreate'}" class="btn btn-outline-primary">Добавить вручную</router-link>
                    <router-link :to="{name: 'NomenclaturesImport'}" class="btn btn-primary">Добавить из каталога WB</router-link>
                </div>
            </div>
        </div>

        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="table-wrapper">
            <ag-grid-vue v-if="nomenclatures.length"
                class="ag-theme-alpine catalog-table"
                :defaultColDef="table.defaultColDef"
                :columnDefs="table.columns"
                :rowData="table.data"
                @grid-ready="onGridReady"
                rowSelection="multiple"
                @row-double-clicked="onRowClicked"
            >
            </ag-grid-vue>

            <p v-else class="text-muted">Нет номенклатуры.</p>
            
            <button @click="toArchive()" v-if="selected.nomenclatures.length">В архив</button>
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
                nomenclatures: [],

                table: {
                    data: [],
                    columns: [
                        { field: "type", headerName: 'Тип', valueFormatter: this.typeFormatter },
                        { field: "artnumber", headerName: 'Артикул'  },
                        { field: "name", headerName: 'Тип' },
                        { field: "brand", headerName: 'Производитель' },
                        { field: "quantity", headerName: 'Кол-во' },
                        { field: "cost_price", headerName: 'Себестоимость', valueFormatter: this.currencyFormatter },
                    ],
                    defaultColDef: {
                        movable: false,
                        suppressMovable: true,
                        suppressRowClickSelection: true,
                    },
                },

                selected: {
                    nomenclatures: [],
                },

                views: {
                    loading: true,
                }
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
            this.$parent.views.title = 'Номенклатура'

            this.loadNomenclatures()
        },
        methods: {
            loadNomenclatures() {
                let user = this.$parent.user

                if(!user) {
                    return
                }

                axios.get(`/api/nomenclatures`, { params: { user: user.uid } })
                .then(response => (
                    this.nomenclatures = response.data,
                    this.table.data = this.nomenclatures,
                    this.views.loading = false
                ))
                .catch(error => {
                    this.$swal({
                        text: error,
                        icon: 'error',
                    })
                })
            },
            typeFormatter(params) {
                if(params.value == 'tovar') {
                    return 'товар'
                }
                if(params.value == 'usluga') {
                    return 'услуга'
                }
                if(params.value == 'raskhodnik') {
                    return 'расходник'
                }
            },
            currencyFormatter(params) {
                return this.$options.filters.currency(params.value);
            },
            onGridReady(params) {
                this.gridApi = params.api
                this.gridColumnApi = params.gridColumnApi
                
                this.gridApi.sizeColumnsToFit()
            },
            onRowClicked(event) {
                this.$router.push({name: 'Nomenclature', params: {uid: event.data.uid}})
            },
        },
        components: {
            Loader,
            AgGridVue
        }
    }
</script>
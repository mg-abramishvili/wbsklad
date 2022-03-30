<template>
    <div class="prices-list warehouse-page">
        <div class="top-block flex">
            <p>Список товаров</p>
            <div class="buttons other">
                <form>
                    <input type="text" placeholder="Поиск">
                </form>
                <button @click="tableColumnsSettingsToggle()">Вид</button>
                <button @click="loadFromWildberries()">Обновить</button>
            </div>
        </div>

        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="table-wrapper">
            <div v-if="views.tableColumnsSettings" class="table-view-parameters">
                <ul>
                    <li v-for="column in table.allColumns">
                        <input v-model="table.userColumns" type="checkbox" :value="column.id" :id="'col_v_' + column.field">
                        <label :for="'col_v_' + column.field">{{ column.headerName }}</label>
                    </li>
                </ul>
                <button @click="saveTableColumnsSettings()">Сохранить</button>
            </div>

            <ag-grid-vue
                class="ag-theme-alpine catalog-table"
                :columnDefs="table.selectedColumns"
                :rowData="table.data"
                @column-resized="onColumnResized"
            >
            </ag-grid-vue>
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
                products: [],

                table: {
                    data: [],
                    allColumns: [],
                    userColumns: [],
                    selectedColumns: [],
                },

                views: {
                    loading: true,
                    tableColumnsSettings: false,
                }
            }
        },
        created() {
            this.loadProducts()
        },
        methods: {
            loadProducts() {
                let user = this.$parent.user

                if(!user) {
                    return
                }

                axios.get(`/api/user/${user.uid}/products`)
                .then(response => (
                    this.products = response.data,
                    this.views.loading = false,
                    this.loadTable()
                ))
                .catch(error => {
                    this.$swal({
                        text: error,
                        icon: 'error',
                    })
                })
            },
            loadFromWildberries() {
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

                this.views.loading = true

                axios.get(`/api/user/${user.uid}/products/wildberries/load`)
                .then((response => {
                    if(response.data) {
                        this.loadProducts()
                        this.views.loading = false

                        this.$swal({
                            text: 'Товары загружены!',
                            icon: 'success',
                        })
                    }
                }))
                .catch(error => {
                    this.$swal({
                        text: error.response.data,
                        icon: 'error',
                    })
                })
            },
            productImage(nm) {
                let nmImageCategory = nm.toString().slice(0,4) + '0000'
                let nmImageName = nm + '-1.avif'
                
                return 'https://images.wbstatic.net/c246x328/new/' + nmImageCategory + '/' + nmImageName
            },
            loadTable() {
                axios.get(`/api/catalog-table-columns`)
                .then((response => {
                    this.table.allColumns = response.data

                    this.table.userColumns = this.$parent.user.catalog_table_columns.map(column => column.id)
                    
                    this.table.selectedColumns = this.table.allColumns.filter(column => this.table.userColumns.includes(column.id))
                    
                    this.table.data = this.products
                }))
                .catch(error => {
                    this.$swal({
                        text: error.response.data,
                        icon: 'error',
                    })
                })

            },
            onColumnResized(event) {
                console.log(event)
            },
            tableColumnsSettingsToggle() {
                if(this.views.tableColumnsSettings) {
                    return this.views.tableColumnsSettings = false
                }
                if(!this.views.tableColumnsSettings) {
                    return this.views.tableColumnsSettings = true
                }
            },
            saveTableColumnsSettings() {
                axios.put(`/api/catalog-table-columns`, {
                    uid: this.$parent.user.uid,
                    columns: this.table.userColumns
                })
                .then((response => {
                    this.table.selectedColumns = this.table.allColumns.filter(column => this.table.userColumns.includes(column.id))
                }))
                .catch(error => {
                    this.$swal({
                        text: error.response.data,
                        icon: 'error',
                    })
                })
                
                this.views.tableColumnsSettings = false
            }
        },
        components: {
            Loader,
            AgGridVue
        }
    }
</script>
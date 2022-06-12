<template>
    <div class="catalog-page">
        <div class="row mb-4 align-items-center">
            <div class="col-12 col-lg-5">
                <input type="text" placeholder="Поиск по товарам" class="form-control">
            </div>
            <div class="col-12 col-lg-7">
                <div class="text-right">
                    <button @click="toggleTableSettings()" class="btn btn-outline-primary">Вид</button>
                    <button @click="loadFromWildberries()" class="btn btn-primary" :disabled="!views.loadButton">Обновить</button>
                </div>
            </div>
        </div>

        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="table-wrapper">
            <div v-if="views.table.settings" class="card border-bottom-primary shadow py-2 mb-4 table-view-parameters">
                <div class="card-body">
                    <ul>
                        <li v-for="column in table.userColumns" :key="column.id">
                            <input v-model="table.userColumns.find(c => c.id == column.id).isActive" type="checkbox" :value="column.isActive" :id="'col_v_' + column.field">
                            <label :for="'col_v_' + column.field">{{ column.headerName }}</label>
                        </li>
                    </ul>
                    <button @click="saveTableSettings()" class="btn btn-primary">Сохранить</button>
                </div>
            </div>

            <ag-grid-vue v-if="products.length"
                class="ag-theme-alpine catalog-table"
                :defaultColDef="table.defaultColDef"
                :columnDefs="table.userColumns.filter(col => col.isActive == true)"
                :rowData="products"
                @column-resized="onColumnEdited"
                @column-moved="onColumnEdited"
                @row-double-clicked="onRowClicked"
                enableCellTextSelection="true"
                ensureDomOrder="true"
            >
            </ag-grid-vue>

            <p v-else class="text-muted">Нет товаров WB. Нажмите кнопку "Обновить" для загрузки товаров.</p>
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
                    userColumns: [],
                    defaultColDef: {
                        sortable: true,
                        movable: false,
                        suppressMovable: true,
                    },
                },

                views: {
                    loading: true,
                    table: {
                        settings: false,
                    },
                    loadButton: true,
                }
            }
        },
        created() {
            this.$parent.views.title = 'Каталог WB'

            this.loadProducts()
        },
        methods: {
            loadProducts() {
                let user = this.$parent.user

                if(!user) {
                    return
                }

                axios.get(`/api/products`, { params: { user: user.uid } })
                .then(response => {
                    this.products = response.data
                    this.views.loading = false
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
                let user = this.$parent.user

                if(!user) {
                    return
                }

                axios.get(`/api/table-views`, { params: { user: user.uid } })
                .then((response => {                    
                    this.table.userColumns = response.data.find(tableView => tableView.table_name == 'products').columns
                }))
                .catch(error => {
                    this.$swal({
                        text: error.response.data,
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

                this.views.loadButton = false
                this.views.loading = true

                axios.get(`/api/products/wildberries/load`, { params: { user: user.uid } })
                .then((response => {
                    if(response.data) {
                        this.loadProducts()
                        this.views.loading = false
                        this.views.loadButton = true

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
            onColumnEdited(event) {
                let newColumnParams = event.api.columnModel.gridColumns.map((column, index) => {
                    return {
                        'id': column.colDef['id'],
                        'field': column['colId'],
                        'headerName': column.colDef['headerName'],
                        'width': column['actualWidth'],
                        'order': column + 1,
                        'isActive': column.colDef['isActive']
                    }
                })

                newColumnParams.forEach(column => {
                    let col = this.table.userColumns.find(c => c.id === column.id)

                    if(col) {
                        col.id = column.id
                        col.field = column.field
                        col.headerName = column.headerName
                        col.width = column.width
                        col.order = column.order
                        col.isActive = column.isActive
                    }
                })
            },
            toggleTableSettings() {
                if(this.views.table.settings) {
                    this.table.defaultColDef.resizable = false
                    this.table.defaultColDef.suppressMovable = true

                    return this.views.table.settings = false
                }
                if(!this.views.table.settings) {
                    this.table.defaultColDef.resizable = true
                    this.table.defaultColDef.suppressMovable = false

                    return this.views.table.settings = true
                }
            },
            saveTableSettings() {
                axios.post(`/api/table-views`, {
                    user: this.$parent.user.uid,
                    table_name: 'products',
                    columns: this.table.userColumns
                })
                .then((response => {
                    //
                }))
                .catch(error => {
                    this.$swal({
                        text: error.response.data,
                        icon: 'error',
                    })
                })

                this.toggleTableSettings()
            },
            onRowClicked(event) {
                this.$router.push({name: 'Product', params: {id: event.data.id}})
            },
        },
        components: {
            Loader,
            AgGridVue
        }
    }
</script>
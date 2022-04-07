<template>
    <div class="prices-list warehouse-page">
        <div class="top-block flex">
            <p>Номенклатура</p>
            <div class="buttons other">
                <form>
                    <input type="text" placeholder="Поиск">
                </form>
                <button>Вид</button>
                <button>Обновить</button>
            </div>
        </div>

        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="table-wrapper">
            <div v-if="views.table.settings" class="table-view-parameters">
                <ul>
                    <li v-for="column in table.userColumns" :key="column.id">
                        <input v-model="table.userColumns.find(c => c.id == column.id).isActive" type="checkbox" :value="column.isActive" :id="'col_v_' + column.field">
                        <label :for="'col_v_' + column.field">{{ column.headerName }}</label>
                    </li>
                </ul>
                <button @click="saveTableSettings()">Сохранить</button>
            </div>

            <ag-grid-vue v-if="products.length"
                class="ag-theme-alpine catalog-table"
                :defaultColDef="table.defaultColDef"
                :columnDefs="userColumns"
                :rowData="table.data"
                @column-resized="onColumnEdited"
                @column-moved="onColumnEdited"
            >
            </ag-grid-vue>

            <p v-else>Нет товаров WB. Нажмите кнопку "Обновить" для загрузки товаров.</p>
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
                    userColumns: [],
                    userColumnsParams: [],
                    defaultColDef: {
                        movable: false,
                        suppressMovable: true,
                    },
                },

                views: {
                    loading: true,
                    table: {
                        settings: false
                    },
                }
            }
        },
        computed: {
            userColumns() {
                if(this.table.userColumns && this.table.userColumns.length) {
                    return this.table.userColumns.filter(c => c.isActive == true)
                }
            },
        },
        created() {
            this.loadNomenclatures()
        },
        methods: {
            loadNomenclatures() {
                let user = this.$parent.user

                if(!user) {
                    return
                }

                axios.get(`/api/user/${user.uid}/nomenclatures`)
                .then(response => (
                    this.nomenclatures = response.data,
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

                this.views.loading = true

                axios.get(`/api/user/${user.uid}/nomenclatures/load`)
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
            loadTable() {
                axios.get(`/api/user-catalog-table-columns/${this.$parent.user.uid}`)
                .then((response => {                    
                    this.table.userColumns = response.data.data
                    
                    this.table.data = this.products
                }))
                .catch(error => {
                    this.$swal({
                        text: error.response.data,
                        icon: 'error',
                    })
                })

            },
            columnsEdit(param) {
                this.table.defaultColDef.resizable = param
                this.table.defaultColDef.suppressMovable = !param

                let tempData = this.table.userColumns
                this.table.userColumns = []

                setTimeout(() => {
                    this.table.userColumns = tempData
                }, 50)
            },
            onColumnEdited(event) {
                this.table.userColumnsParams = event.api.columnModel.gridColumns.map(function(item, index) { return {'id': item.colDef['id'], 'field': item['colId'], 'headerName': item.colDef['headerName'], 'width': item['actualWidth'], 'order': index + 1, 'isActive': item.colDef['isActive']} })
            },
            toggleTableSettings() {
                if(this.views.table.settings) {
                    this.columnsEdit(false)

                    return this.views.table.settings = false
                }
                if(!this.views.table.settings) {
                    this.columnsEdit(true)

                    return this.views.table.settings = true
                }
            },
            saveTableSettings() {
                let data = ''

                if(this.table.userColumnsParams && this.table.userColumnsParams.length) {
                    data = this.table.userColumnsParams
                } else {
                    data = this.table.userColumns
                }

                axios.put(`/api/user-catalog-table-columns`, {
                    uid: this.$parent.user.uid,
                    columns_params: data
                })
                .then((response => {
                    this.table.userColumns = data
                }))
                .catch(error => {
                    this.$swal({
                        text: error.response.data,
                        icon: 'error',
                    })
                })
                this.toggleTableSettings()
            }
        },
        components: {
            Loader,
            AgGridVue
        }
    }
</script>
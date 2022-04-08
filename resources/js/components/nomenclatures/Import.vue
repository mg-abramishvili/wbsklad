<template>
    <div class="prices-list warehouse-page">
        <div class="top-block flex">
            <p>
                <router-link :to="{name: 'Nomenclatures'}">&larr; Назад</router-link>
                Импорт из каталога WB
            </p>
            <div class="buttons other">
                <button @click="save()">Начать импорт</button>
            </div>
        </div>

        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="table-wrapper">
            <ag-grid-vue v-if="products.length"
                class="ag-theme-alpine catalog-table"
                :defaultColDef="table.defaultColDef"
                :columnDefs="userColumns"
                :rowData="table.data"
                rowSelection="multiple"
                @selection-changed="onSelectionChanged"
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
                    userColumns: [],
                    defaultColDef: {
                        movable: false,
                        suppressMovable: true,
                        suppressRowClickSelection: true,
                    },
                },

                selected: {
                    products: [],
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
            this.loadProducts()
        },
        methods: {
            loadProducts() {
                let user = this.$parent.user

                if(!user) {
                    return
                }

                axios.get(`/api/products`, { params: { user: user.uid } })
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
            loadTable() {
                this.table.userColumns = [
                    { field: '', checkboxSelection: true, width: 50 },
                    { field: "nm_id", headerName: 'Код WB' },
                    { field: "supplier_article", headerName: 'Артикул' },
                    { field: "subject", headerName: 'Предмет' },
                    { field: "brand", headerName: 'Бренд' },
                    { field: "category", headerName: 'Категория' },
                    { field: "price", headerName: 'Цена' },
                ]
                    
                this.table.data = this.products
            },
            onSelectionChanged(event) {
                let selectedNodes = event.api.getSelectedNodes()
                let selectedData = selectedNodes.map(node => node.data)

                this.selected.products = selectedData
            },
            save() {
                let user = this.$parent.user

                if(!user) {
                    return
                }

                if(!this.selected.products.length) {
                    return this.$swal({
                        text: 'Выберите хотя бы один товар',
                        icon: 'error',
                    })
                }

                console.log(user)
                console.log(this.selected.products.map(product => product.id))

                axios.post(`/api/nomenclatures/import`, {
                    user: user.uid,
                    products: this.selected.products.map(product => product.id)
                })
                .then(response => {
                    this.$router.push({name: 'Nomenclatures'})
                })
                .catch(error => {
                    this.$swal({
                        text: error,
                        icon: 'error',
                    })
                })
            },
        },
        components: {
            Loader,
            AgGridVue
        }
    }
</script>
<template>
    <div class="prices-list warehouse-page">
        <div class="top-block flex">
            <p>Список товаров</p>
            <div class="buttons other">
                <form>
                    <input type="text" placeholder="Поиск">
                </form>
                <button @click="loadFromWildberries()">Обновить</button>
            </div>
        </div>

        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="table-wrapper">
            <table class="other">
                <thead>
                    <tr>
                        <th></th>
                        <th>Код WB</th>
                        <th>Предмет</th>
                        <th>Категория</th>
                        <th>Бренд</th>
                        <th>Артикул</th>
                        <th>Размер</th>
                        <th>Штрихкод</th>
                        <th>Кол-во для продажи</th>
                        <th>Кол-во полное</th>
                        <th>Кол-во не в заказе</th>
                        <th>Название склада</th>
                        <th>В пути к клиенту</th>
                        <th>В пути от клиента</th>
                        <th>Дней на сайте</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(product, index) in products" :key="product.barcode">
                        <td>
                            {{ index + 1 }}
                        </td>
                        <td>
                            {{ product.nm_id }}
                        </td>
                        <td>
                            {{ product.subject }}
                        </td>
                        <td>
                            {{ product.category }}
                        </td>
                        <td>
                            {{ product.brand }}
                        </td>
                        <td>
                            {{ product.supplier_article }}
                        </td>
                        <td>
                            {{ product.techSize }}
                        </td>
                        <td>
                            {{ product.barcode }}
                        </td>
                        <td>
                            {{ product.quantity }}
                        </td>
                        <td>
                            {{ product.quantityFull }}
                        </td>
                        <td>
                            {{ product.quantityNotInOrders }}
                        </td>
                        <td>
                            {{ product.warehouseName }}
                        </td>
                        <td>
                            {{ product.inWayToClient }}
                        </td>
                        <td>
                            {{ product.inWayFromClient }}
                        </td>
                        <td>
                            {{ product.daysOnSite }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
    import Loader from '../Loader.vue'

    export default {
        data() {
            return {
                products: [],

                views: {
                    loading: true,
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
                    this.views.loading = false
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

                axios.get(`/api/user/${user.uid}/products/wildberries/load`)
                .then(response => (
                    this.loadProducts()
                ))
                .catch(error => {
                    this.$swal({
                        text: error.response,
                        icon: 'error',
                    })
                })
            },
        },
        components: {
            Loader
        }
    }
</script>
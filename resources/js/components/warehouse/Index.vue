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
                        <th></th>
                        <th>Код WB</th>
                        <th>Предмет</th>
                        <th>Артикул</th>
                        <th>Категория</th>
                        <th>Бренд</th>
                        <th>Цена</th>
                        <th>Размер</th>
                        <th>Штрихкод</th>
                        <th style="text-align: center;">Кол-во для продажи</th>
                        <!-- <th>Кол-во полное</th>
                        <th>Кол-во не в заказе</th>
                        <th>Название склада</th>
                        <th>В пути к клиенту</th>
                        <th>В пути от клиента</th>
                        <th>Дней на сайте</th> -->
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(product, index) in products" :key="product.barcode">
                        <td style="text-align: center;">
                            {{ index + 1 }}
                        </td>
                        <td>
                            <img v-if="productImage(product.nm_id)" :src="productImage(product.nm_id)" style="width: 50px; height: auto;" />
                        </td>
                        <td>
                            {{ product.nm_id }}
                        </td>
                        <td>
                            {{ product.subject }}
                        </td>
                        <td>
                            {{ product.supplier_article }}
                        </td>
                        <td>
                            {{ product.category }}
                        </td>
                        <td>
                            {{ product.brand }}
                        </td>
                        <td>
                            {{ product.price }} руб
                        </td>
                        <td>
                            {{ product.tech_size }}
                        </td>
                        <td>
                            {{ product.barcode }}
                        </td>
                        <td style="text-align: center;">
                            {{ product.quantity }}
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
        },
        components: {
            Loader
        }
    }
</script>
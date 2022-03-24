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
            <pre>
                {{ products }}
            </pre>
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
                axios.post(`https://content-suppliers.wildberries.ru/card/list`, {
                    id: 1,
                    jsonrpc: "2.0",
                    supplierID: "3fa85f64-5717-4562-b3fc-2c963f66afa6",
                    withError: true
                })
                .then(response => (
                    console.log(response),
                    this.products = response.data,
                    this.views.loading = false
                ))
                .catch(error => {
                    // this.$swal({
                    //     text: error,
                    //     icon: 'error',
                    // })
                    console.log(error)
                })
            },
        },
        components: {
            Loader
        }
    }
</script>
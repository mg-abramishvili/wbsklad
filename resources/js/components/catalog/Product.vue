<template>
    <Loader v-if="views.loading" />

    <div v-else class="catalog-page">
        <div class="mb-4">
            <router-link :to="{name: 'Catalog'}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left mr-2"></i>
                Назад к списку товаров
            </router-link>
        </div>

        <Loader v-if="views.loading" />
        
        <div v-if="!views.loading" class="card border-bottom-primary shadow py-2 mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <p>
                            <strong class="text-muted">Наименование:</strong><br>
                            {{ product.subject }}
                        </p>
                        <p>
                            <strong class="text-muted">Категория:</strong><br>
                            {{ product.category }}
                        </p>
                        <p>
                            <strong class="text-muted">Бренд:</strong><br>
                            {{ product.brand }}
                        </p>
                        <p>
                            <strong class="text-muted">Размер:</strong><br>
                            {{ product.tech_size }}
                        </p>                        
                    </div>
                    <div class="col-12 col-lg-4">
                        <p>
                            <strong class="text-muted">Код WB:</strong><br>
                            {{ product.nm_id }}
                        </p>
                        <p>
                            <strong class="text-muted">Артикул:</strong><br>
                            {{ product.supplier_article }}
                        </p>
                        <p>
                            <strong class="text-muted">Штрихкод:</strong><br>
                            {{ product.barcode }}
                        </p>
                    </div>
                    <div class="col-12 col-lg-4">
                        <p>
                            <strong class="text-muted">Цена:</strong><br>
                            {{ product.price | currency }}
                        </p>
                        <p>
                            <strong class="text-muted">Себестоимость:</strong><br>
                            {{ product.nomenclatures.reduce((a, b) => +a + +b.cost_price, 0) | currency }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Loader from '../Loader.vue'

    export default {
        data() {
            return {
                product: {},

                views: {
                    loading: true,
                }				
            }
        },
        created() {
            this.loadProduct()
        },
		methods: {
            loadProduct() {
                axios.get(`/api/product/${this.$route.params.id}`)
                .then(response => {
                    this.product = response.data

                    this.$parent.views.title = response.data.subject + ' ' + response.data.supplier_article

                    this.views.loading = false
                })
                .catch(errors => {
                    this.$swal({
                        text: 'Ошибка',
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
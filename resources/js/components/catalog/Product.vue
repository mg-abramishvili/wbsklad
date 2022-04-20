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

        <div v-if="!views.loading" class="row">
            <div class="col-12 col-lg-6">
                <div class="card border-bottom-primary shadow py-2 mb-4">
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
                                    {{ pricePreview | currency }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card border-bottom-primary shadow py-2 mb-4">
                    <div class="card-body">
                        <h5>Связь с номенклатурой</h5>
                        
                        <input v-model="nomenclatureSearchInput" type="text" class="form-control mb-1" placeholder="Поиск по номенклатуре...">
                        <div class="form-control" style="height: 280px; overflow-y: auto;">
                            <div v-for="nomenclature in nomenclaturesFiltered" :key="'nomenclature_' + nomenclature.id" class="row align-items-center">
                                <div class="col-8">
                                    <div class="pl-4">
                                        <input v-model="selected.nomenclatures" @change="selectedNomenclatures(nomenclature.id, $event)" :id="'nomenclature_' + nomenclature.id" :value="nomenclature.id" class="form-check-input" type="checkbox">
                                        <label class="form-check-label" :for="'nomenclature_' + nomenclature.id">
                                            {{ nomenclature.name }} - {{ nomenclature.cost_price | currency }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-4 text-right">
                                    <input v-if="selected.nomenclatures.includes(nomenclature.id)" v-model="selected.nomenclaturesQty.find(q => q.id == nomenclature.id).quantity" type="number" min="0" class="form-control form-control-mini-number">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button @click="save()" class="btn btn-primary">Сохранить</button>
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

                nomenclatures: [],
                
                selected: {
                    nomenclatures: [],
                    nomenclaturesQty: [],
                },

                nomenclatureSearchInput: '',

                views: {
                    loading: true,
                }				
            }
        },
        computed: {
            nomenclaturesFiltered() {
                let filtered = this.nomenclatures.filter(nomenclature => {
                    return nomenclature.name.toLowerCase().includes(this.nomenclatureSearchInput.toLowerCase())
                })

                return filtered.filter(nomenclature => this.selected.nomenclatures.includes(nomenclature.id)).concat(filtered.filter(nomenclature => !this.selected.nomenclatures.includes(nomenclature.id)))
            },
            pricePreview() {
                let selectedNomenclatures = this.nomenclatures.filter(nomenclature => this.selected.nomenclatures.includes(nomenclature.id))
                
                return selectedNomenclatures.map(nomenclature => nomenclature.cost_price * this.selected.nomenclaturesQty.find(q => q.id == nomenclature.id).quantity).reduce((a, b) => parseInt(a) + parseInt(b), 0)
            },
        },
        created() {
            this.loadProduct()
            this.loadNomenclatures()
        },
		methods: {
            loadProduct() {
                axios.get(`/api/product/${this.$route.params.id}`)
                .then(response => {
                    this.product = response.data

                    this.$parent.views.title = response.data.subject + ' ' + response.data.supplier_article

                    this.selected.nomenclatures = response.data.nomenclatures.map(item => item.id)
                    this.selected.nomenclaturesQty = response.data.nomenclatures.map(({id, pivot}) => ({id: id, quantity: pivot.quantity}))
                })
                .catch(errors => {
                    this.$swal({
                        text: 'Ошибка',
                        icon: 'error',
                    })
                })
            },
			loadNomenclatures() {
                let user = this.$parent.user

                if(!user) {
                    return
                }

                axios.get(`/api/nomenclatures`, { params: { user: user.uid } })
                .then(response => {
                    this.nomenclatures = response.data
                    this.views.loading = false
                })
                .catch(error => {
                    this.$swal({
                        text: error,
                        icon: 'error',
                    })
                })
            },
            selectedNomenclatures(id) {
                if(event.target.checked) {
                    this.selected.nomenclaturesQty.push({id: id, quantity: 1})
                } else {
                    this.selected.nomenclaturesQty = this.selected.nomenclaturesQty.filter(qty => qty.id !== id)
                }
            },
            save() {
                axios.put(`/api/product/${this.$route.params.id}/update`,
                {
                    nomenclatures: this.selected.nomenclaturesQty,
                })
                .then(response => (
                    this.$router.push({name: 'Catalog'}) 
                ))
                .catch((error) => {
                    if(error.response) {
                        for(var key in error.response.data.errors){
                            console.log(key)
                        }
                    }
                })
            },
		},
        components: {
            Loader
        }
    }
</script>
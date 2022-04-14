<template>
    <Loader v-if="views.loading" />

    <div v-else class="stockbalances-pages">
        <div class="mb-4">
            <router-link :to="{name: 'StockBalances'}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left mr-2"></i>
                Назад к списку поступлений
            </router-link>
        </div>

        <div class="card border-bottom-primary shadow py-2 mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="mb-0">
                            <label>Поиск по назанию или артикулу</label>
                            <input v-model="search" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <ul class="m-0 p-0">
                            <li v-for="nomenclature in nomenclatures">
                                {{ nomenclature.name }} ({{ nomenclature.artnumber }})
                            </li>
                        </ul>
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
                nomenclatures: [],

                selected: {
                    nomenclature: '',
                },

                views: {
                    loading: true,
                }				
            }
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

                axios.get(`/api/nomenclatures`, { params: { user: user.uid } })
                .then(response => (
                    this.nomenclatures = response.data,
                    this.views.loading = false
                ))
                .catch(error => {
                    this.$swal({
                        text: error,
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
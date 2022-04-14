<template>
    <Loader v-if="views.loading" />

    <div v-else class="stockbalances-pages">
        <div class="mb-4">
            <router-link :to="{name: 'StockBalances'}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left mr-2"></i>
                Назад к списку поступлений
            </router-link>
        </div>

        <div v-if="!selected.nomenclature" class="row">
            <div class="col-12 col-lg-5">
                <div class="card border-bottom-primary shadow py-2 mb-4">
                    <div class="card-body">
                        <div class="mb-0">
                            <label>Поиск по назанию или артикулу</label>
                            <input v-model="search" type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-7">
                <div class="card border-bottom-primary shadow py-2 mb-4">
                    <div class="card-body">
                        <h6 class="mb-4" style="font-weight: 500; color: #151515;">Выберите номенклатуру</h6>
                        <div class="list-group" style="max-height: 500px; overflow-y: auto;">
                            <a v-for="nomenclature in filteredNomenclatures" @click="selectNomenclature(nomenclature)" class="list-group-item list-group-item-action" style="cursor:pointer;">
                                {{ nomenclature.name }} ({{ nomenclature.artnumber }})
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="selected.nomenclature" class="card border-bottom-primary shadow py-2 mb-4">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-12 col-lg-5">
                        <div class="mb-0">
                            <label>Номенклатура</label>
                            <input type="text" class="form-control" :placeholder="selected.nomenclature.name + ' (' + selected.nomenclature.artnumber + ')'" disabled>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <label>Дата поступления</label>
                        <input v-model="date" type="date" class="form-control">
                    </div>
                    <div class="col-12 col-lg-2">
                        <label>Количество</label>
                        <input v-model="quantity" type="number" min="1" class="form-control">
                    </div>
                    <div class="col-12 col-lg-2">
                        <label>Стоимость</label>
                        <input v-model="price" type="number" min="0" class="form-control">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-12 col-lg-5">
                        <label>Контрагент</label>
                        <select v-model="selected.contractor" class="form-control">
                            <option v-for="contractor in contractors" :value="contractor.id">{{ contractor.name }}</option>
                        </select>
                    </div>
                </div>

                <button @click="save()" :disabled="views.submitButton == false" class="btn btn-primary">Сохранить</button>
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
                contractors: [],

                quantity: 1,
                price: 0,
                date: moment().format('YYYY-MM-DD'),

                search: '',

                selected: {
                    nomenclature: '',
                    contractor: '',
                },

                views: {
                    loading: true,
                    saveButton: true,
                }				
            }
        },
        computed: {
            filteredNomenclatures() {
                return this.nomenclatures.filter(nomenclature => {
                    return nomenclature.name.toLowerCase().includes(this.search.toLowerCase()) || nomenclature.artnumber.toLowerCase().includes(this.search.toLowerCase())
                })
            },
        },
        created() {
            this.$parent.views.title = 'Новое поступление'

            this.loadNomenclatures()
            this.loadContractors()
        },
		methods: {
            loadNomenclatures() {
                let user = this.$parent.user

                if(!user) {
                    return
                }

                axios.get(`/api/nomenclatures`, { params: { user: user.uid } })
                .then(response => (
                    this.nomenclatures = response.data
                ))
                .catch(error => {
                    this.$swal({
                        text: error,
                        icon: 'error',
                    })
                })
            },
            loadContractors() {
                let user = this.$parent.user

                if(!user) {
                    return
                }

                axios.get(`/api/contractors`, { params: { user: user.uid } })
                .then(response => {
                    this.contractors = response.data
                    this.views.loading = false
                })
                .catch(error => {
                    this.$swal({
                        text: error,
                        icon: 'error',
                    })
                })
            },
            selectNomenclature(nomenclature) {
                this.selected.nomenclature = nomenclature
            },
            save() {
                let user = this.$parent.user

                if(!user) {
                    return this.$swal({
                        text: 'Пользователь не найден',
                        icon: 'error',
                    })
                }

                if(!this.quantity) {
                    return this.$swal({
                        text: 'Укажите количество',
                        icon: 'error',
                    })
                }

                if(!this.selected.contractor) {
                    return this.$swal({
                        text: 'Укажите контрагента',
                        icon: 'error',
                    })
                }

				this.views.saveButton = false

                axios.post(`/api/stockbalances`, {
                    user: user.uid,
                    nomenclature_id: this.selected.nomenclature.id,
                    contractor_id: this.selected.contractor,
                    quantity: this.quantity,
                    price: this.price,
                    date: this.date
                })
                .then(response => {
                    this.$router.push({name: 'StockBalances'})
                })
                .catch(error => {
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
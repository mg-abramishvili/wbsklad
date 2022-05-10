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
                    <div class="col-12 col-lg-4">
                        <div class="mb-0">
                            <label>Контрагент</label>
                            <select v-model="selected.contractor" class="form-control">
                                <option v-for="contractor in contractors" :value="contractor.id">{{ contractor.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="mb-0">
                            <label>Дата поступления</label>
                            <input v-model="date" type="date" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card border-bottom-primary shadow py-2 mb-4">
            <div class="card-body">
                <div class="row align-items-center mb-4">
                    <div class="col-12 col-lg-6">
                        <label class="m-0">Позиции</label>
                    </div>
                    <div class="col-12 col-lg-6 text-right">
                        <button @click="addRow()" class="btn btn-sm btn-primary">Добавить строку</button>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>№</td>
                            <td>Артикул</td>
                            <td>Наименование</td>
                            <td>Бренд</td>
                            <td>Кол-во</td>
                            <td>Стоимость</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(nomenclature, index) in selected.nomenclatures">
                            <td style="width: 5%;">{{ index + 1 }}</td>
                            <td style="width: 20%;">
                                <multiselect
                                    v-model="selected.nomenclatures[index]"
                                    :options="nomenclatures"
                                    :max-height="150"
                                    label="artnumber"
                                    placeholder=""
                                    selectLabel=""
                                    deselectLabel=""
                                    selectedLabel=""
                                ></multiselect>
                            </td>
                            <td style="width: 27.5%;">
                                <multiselect
                                    v-model="selected.nomenclatures[index]"
                                    :options="nomenclatures"
                                    :max-height="150"
                                    label="name"
                                    :custom-label="nameWithArtnumber"
                                    placeholder=""
                                    selectLabel=""
                                    deselectLabel=""
                                    selectedLabel=""
                                ></multiselect>
                            </td>
                            <td style="width: 20%;">
                                <input v-model="nomenclature.brand" type="text" class="form-control">
                            </td>
                            <td style="width: 10%;">
                                <input v-model="nomenclature.quantity" type="number" min="1" class="form-control">
                            </td>
                            <td style="width: 7.5%;">
                                <input v-model="nomenclature.price" type="number" min="0" class="form-control">
                                {{ nomenclature.total }}
                            </td>
                            <td style="width: 7.5%;" class="text-center">
                                <button @click="deleteRow(index)" class="btn btn-sm btn-danger">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card border-bottom-primary shadow py-2 mb-4">
            <div class="card-body">
                <div class="row align-items-center mb-4">
                    <div class="col-12 col-lg-6">
                        <label class="m-0">Доставка</label>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td></td>
                            <td>Контрагент</td>
                            <td>Стоимость</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width: 20%;">
                                <input value="Доставка" type="text" class="form-control" disabled>
                            </td>
                            <td style="width: 20%;">
                                <select v-model="selected.delivery.contractor" class="form-control">
                                    <option v-for="contractor in contractors" :value="contractor.id">{{ contractor.name }}</option>
                                </select>
                            </td>
                            <td style="width: 10%;">
                                <input v-model="selected.delivery.price" type="number" min="0" class="form-control">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <button @click="save()" class="btn btn-primary">Сохранить</button>
    </div>
</template>

<script>
    import Loader from '../Loader.vue'

    export default {
        data() {
            return {
                nomenclatures: [],
                contractors: [],

                date: moment().format('YYYY-MM-DD'),

                selected: {
                    contractor: '',
                    nomenclatures: [],
                    delivery: {
                        price: '',
                        contractor: '',
                    },
                },

                views: {
                    loading: true,
                    saveButton: true,
                }				
            }
        },
        watch: {
            selected: {
                deep: true,
                handler() {
                    this.selected.nomenclatures.forEach(nomenclature => {
                        if(!nomenclature.price) {
                            nomenclature.price = 0
                        }
                        if(this.selected.delivery.price) {
                            return nomenclature.total = parseInt(nomenclature.price) + (parseInt(this.selected.delivery.price) / this.selected.nomenclatures.length / nomenclature.quantity)
                        }
                        if(!this.selected.delivery.price) {
                            return nomenclature.total = parseInt(nomenclature.price)
                        }
                    })
                }
            }
        },
        created() {
            this.$parent.views.title = 'Новое поступление'

            this.loadContractors()
            this.loadNomenclatures()
        },
		methods: {
            loadNomenclatures() {
                let user = this.$parent.user

                if(!user) {
                    return
                }

                axios.get(`/api/nomenclatures`, { params: { user: user.uid } })
                .then(response => {
                    this.nomenclatures = response.data.data.map(n => ({
                        id: n.id,
                        name: n.name,
                        artnumber: n.artnumber,
                        brand: n.brand,
                        quantity: 1,
                        price: 0,
                        total: 0,
                    }))

                    this.views.loading = false
                    this.addRow()
                })
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
                })
                .catch(error => {
                    this.$swal({
                        text: error,
                        icon: 'error',
                    })
                })
            },
            addRow() {
                this.selected.nomenclatures.push({
                    id: '',
                    name: '',
                    brand: '',
                    quantity: 1,
                    price: 0,
                    total: 0,
                })
            },
            deleteRow(index) {
                if(this.selected.nomenclatures.length <= 1) {
                    return
                }

                this.selected.nomenclatures.splice(index, 1)
            },
            nameWithArtnumber ({ name, artnumber }) {
                if(!name) {
                    return
                }
                return `${name} [${artnumber}]`
            },
            save() {
                let user = this.$parent.user

                if(!user) {
                    return this.$swal({
                        text: 'Пользователь не найден',
                        icon: 'error',
                    })
                }

                if(!this.date) {
                    return this.$swal({
                        text: 'Укажите дату',
                        icon: 'error',
                    })
                }

                if(!this.selected.contractor) {
                    return this.$swal({
                        text: 'Укажите контрагента',
                        icon: 'error',
                    })
                }

                if(!this.selected.nomenclatures[0].artnumber) {
                    return this.$swal({
                        text: 'Укажите номенклатуру',
                        icon: 'error',
                    })
                }

				this.views.saveButton = false

                axios.post(`/api/stockbalances`, {
                    user: user.uid,
                    date: this.date,
                    contractor_id: this.selected.contractor,
                    nomenclatures: this.selected.nomenclatures,
                    delivery: this.selected.delivery,
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
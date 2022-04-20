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
                        <label class="m-0">Услуги</label>
                    </div>
                    <div class="col-12 col-lg-6 text-right">
                        <button @click="addServiceRow()" class="btn btn-sm btn-primary">Добавить строку</button>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <td>№</td>
                            <td>Услуга</td>
                            <td>Контрагент</td>
                            <td>Сумма</td>
                            <td>Номенклатура</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(service, index) in selected.services">
                            <td style="width: 5%;">{{ index + 1 }}</td>
                            <td style="width: 20%;">
                                <input v-model="service.name" type="text" class="form-control">
                            </td>
                            <td style="width: 20%;">
                                <input v-model="service.contractor" type="text" class="form-control">
                            </td>
                            <td style="width: 10%;">
                                <input v-model="service.price" type="number" min="0" class="form-control">
                            </td>
                            <td style="width: 25%;">
                                <button @click="selectAllNm(index)" class="btn btn-sm btn-outline-primary">разделить на всех</button>
                                
                                <multiselect
                                    v-model="service.nomenclatures"
                                    :options="selected.nomenclatures"
                                    :max-height="150"
                                    :multiple="true"
                                    label="name"
                                    :custom-label="nameWithArtnumber"
                                    placeholder=""
                                    selectLabel=""
                                    deselectLabel=""
                                    selectedLabel=""
                                    @remove="removeServiceNomenclature($event, service)"
                                ></multiselect>
                            </td>
                            <td style="width: 7.5%;" class="text-center">
                                <button @click="deleteServiceRow(index)" class="btn btn-sm btn-danger">
                                    <i class="far fa-trash-alt"></i>
                                </button>
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
                services: [],

                date: moment().format('YYYY-MM-DD'),

                selected: {
                    contractor: '',
                    nomenclatures: [],
                    services: [],
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

                        let servicePrices = []

                        this.selected.services.forEach(service => {
                            if(service.nomenclatures.find(n => n.id == nomenclature.id)) {
                                if(service.price && service.price > 0) {
                                    servicePrices.push(service.price / service.nomenclatures.length)
                                }
                            }
                        })

                        if(servicePrices.length) {
                            servicePrices = servicePrices.reduce((a, b) => parseInt(a) + parseInt(b), 0)
                        } else {
                            servicePrices = 0
                        }

                        nomenclature.total = parseInt(nomenclature.price) + servicePrices
                    })
                }
            }
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
                    this.nomenclatures = response.data.map(n => ({
                        id: n.id,
                        name: n.name,
                        artnumber: n.artnumber,
                        brand: n.brand,
                        quantity: 1,
                        price: 0,
                        total: 0,
                    }))
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
                    this.addRow()
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
            addServiceRow() {
                this.selected.services.push({
                    name: '',
                    contractor: '',
                    price: 0,
                    nomenclatures: [],
                })
            },
            deleteServiceRow(index) {
                this.selected.services.splice(index, 1)
            },
            removeServiceNomenclature(event, service) {
                let index = service.nomenclatures.indexOf(event)

                service.nomenclatures.splice(index, 1)
            },
            selectAllNm(index) {
                this.selected.services[index].nomenclatures = this.selected.nomenclatures
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
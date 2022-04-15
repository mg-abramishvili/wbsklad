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
                <button @click="addRow()" class="btn btn-sm btn-primary mb-4">Добавить строку</button>
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
                            <td style="width: 25%;">
                                <input v-model="nomenclature.artnumber" @click="openSelectHelper('artnumber', index)" type="text" class="form-control">
                                <ul v-if="views.selectHelpers.artnumber[index].visible && filteredArtnumbers(nomenclature.artnumber) && filteredArtnumbers(nomenclature.artnumber).length" class="select-helper shadow">
                                    <li @click="selectNomenclature(index, n)" v-for="n in filteredArtnumbers(nomenclature.artnumber)" class="my-3" style="cursor:pointer;">
                                        {{ n.artnumber }}
                                    </li>
                                </ul>
                            </td>
                            <td style="width: 25%;">
                                <input v-model="nomenclature.name" @click="openSelectHelper('name', index)" type="text" class="form-control">
                                <ul v-if="views.selectHelpers.name[index].visible && filteredNames(nomenclature.name) && filteredNames(nomenclature.name).length" class="select-helper shadow">
                                    <li @click="selectNomenclature(index, n)" v-for="n in filteredNames(nomenclature.name)" class="my-3" style="cursor:pointer;">
                                        {{ n.name }} <small class="text-muted">{{ n.artnumber }}</small>
                                    </li>
                                </ul>
                            </td>
                            <td style="width: 20%;">
                                <input v-model="nomenclature.brand" type="text" class="form-control">
                            </td>
                            <td style="width: 10%;">
                                <input v-model="nomenclature.quantity" type="number" min="1" class="form-control">
                            </td>
                            <td style="width: 7.5%;">
                                <input v-model="nomenclature.price" type="number" min="0" class="form-control">
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
                },

                views: {
                    loading: true,
                    saveButton: true,
                    selectHelpers: {
                        artnumber: [],
                        name: [],
                    }
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
                    artnumber: '',
                    brand: '',
                    quantity: 1,
                    price: 0,
                })

                this.views.selectHelpers.artnumber = []
                this.views.selectHelpers.name = []

                this.selected.nomenclatures.forEach((n, index) => {
                    this.views.selectHelpers.artnumber.push({
                        index: index,
                        visible: false,
                    })
                    this.views.selectHelpers.name.push({
                        index: index,
                        visible: false,
                    })
                })
            },
            deleteRow(index) {
                if(this.selected.nomenclatures.length <= 1) {
                    return
                }

                let row = this.selected.nomenclatures.indexOf(index)
                
                this.selected.nomenclatures.splice(row, 1)
            },
            filteredArtnumbers(input) {
                if(!input) {
                    return
                }
                return this.nomenclatures.filter(nomenclature => {
                    return nomenclature.artnumber.toLowerCase().includes(input.toLowerCase())
                })
            },
            filteredNames(input) {
                if(!input) {
                    return
                }
                return this.nomenclatures.filter(nomenclature => {
                    return nomenclature.name.toLowerCase().includes(input.toLowerCase())
                })
            },
            selectNomenclature(index, nomenclature) {
                this.selected.nomenclatures[index].id = nomenclature.id
                this.selected.nomenclatures[index].artnumber = nomenclature.artnumber
                this.selected.nomenclatures[index].name = nomenclature.name
                this.selected.nomenclatures[index].brand = nomenclature.brand

                this.views.selectHelpers.artnumber.find(a => a.index == index).visible = false
                this.views.selectHelpers.name.find(a => a.index == index).visible = false
            },
            openSelectHelper(column, index) {
                if(column == 'artnumber') {
                    this.views.selectHelpers.artnumber.find(a => a.index == index).visible = true
                }
                if(column == 'name') {
                    this.views.selectHelpers.name.find(a => a.index == index).visible = true
                }
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
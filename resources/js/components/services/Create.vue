<template>
    <Loader v-if="views.loading" />

    <div v-else class="services-pages">
        <div class="mb-4">
            <router-link :to="{name: 'Services'}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left mr-2"></i>
                Назад к списку услуг
            </router-link>
        </div>

        <div class="card border-bottom-primary shadow py-2 mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-lg-2">
                        <div class="mb-0">
                            <label>Дата</label>
                            <input v-model="date" type="date" class="form-control">
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="mb-3">
                            <label>Название услуги</label>
                            <input v-model="name" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="mb-3">
                            <label>Контрагент</label>
                            <select v-model="selected.contractor" class="form-control">
                                <option v-for="contractor in contractors" :value="contractor.id">{{ contractor.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-lg-2">
                        <div class="mb-3">
                            <label>Стоимость</label>
                            <input v-model="price" type="number" min="0" class="form-control">
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
                            <td style="width: 7.5%;">
                                <input v-model="nomenclature.price" type="number" min="0" class="form-control" disabled>
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
                name: '',
                price: '',
                date: moment().format('YYYY-MM-DD'),
                
                nomenclatures: [],
                contractors: [],

                selected: {
                    contractor: '',
                    nomenclatures: [],
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
                        nomenclature.price = (this.price / this.selected.nomenclatures.length).toFixed(0)
                    })
                }
            }
        },
        created() {
            this.$parent.views.title = 'Новая услуга'

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
                    this.nomenclatures = response.data.data.map(n => ({
                        id: n.id,
                        name: n.name,
                        artnumber: n.artnumber,
                        price: 0,
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
                    artnumber: '',
                    price: 0,
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

                if(!this.name) {
                    return this.$swal({
                        text: 'Укажите название услуги',
                        icon: 'error',
                    })
                }

                if(!this.selected.contractor) {
                    return this.$swal({
                        text: 'Укажите контрагента',
                        icon: 'error',
                    })
                }

                if(!this.price) {
                    return this.$swal({
                        text: 'Укажите стоимость услуги',
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

                axios.post(`/api/services`, {
                    user: user.uid,
                    date: this.date,
                    name: this.name,
                    price: this.price,
                    contractor_id: this.selected.contractor,
                    nomenclatures: this.selected.nomenclatures,
                })
                .then(response => {
                    this.$router.push({name: 'Services'})
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
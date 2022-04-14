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
                <button @click="delConfirm()" class="btn btn-outline-danger">Удалить</button>
            </div>
        </div>
    </div>
</template>

<script>
    import Loader from '../Loader.vue'

    export default {
        data() {
            return {
                contractors: [],
                
                quantity: 1,
                price: 0,
                date: moment().format('YYYY-MM-DD'),

                selected: {
                    nomenclature: {},
                    contractor: '',
                },

                views: {
                    loading: true,
                    saveButton: true,
                }				
            }
        },
        created() {
            this.loadContractors()
            this.loadStockBalance()
        },
		methods: {
            loadStockBalance() {
                axios.get(`/api/stockbalance/${this.$route.params.uid}`)
                .then(response => {
                    this.selected.nomenclature = response.data.nomenclature
                    this.selected.contractor = response.data.contractor.id
                    this.quantity = response.data.quantity
                    this.price = response.data.price
                    this.date = response.data.date

                    this.$parent.views.title = response.data.nomenclature.name

                    this.views.loading = false
                })
                .catch(errors => {
                    this.$swal({
                        text: 'Ошибка',
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
            save() {
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

                axios.put(`/api/stockbalance/${this.$route.params.uid}/update`, {
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
            delConfirm() {
                this.$swal({
                    text: 'Точно удалить поступление?',
                    showCancelButton: true,
                    confirmButtonText: 'Да',
                    cancelButtonText: 'Отмена',
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.del()
                    } else if (result.isDenied) {
                        return
                    }
                })
            },
            del() {
                axios.delete(`/api/stockbalance/${this.$route.params.uid}/delete`)
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
<template>
    <Loader v-if="views.loading" />

    <div v-else class="nomenclatures-pages">
        <div class="mb-4">
            <router-link :to="{name: 'Nomenclatures'}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left mr-2"></i>
                Назад к списку номенклатуры
            </router-link>
        </div>

        <form @submit.prevent="update" class="very-big flex">
            <div class="card border-bottom-primary shadow py-2 mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label>Тип</label>
                                <select v-model="selected.type" class="form-control">
                                    <option value="tovar">Товар</option>
                                    <option value="usluga">Услуга</option>
                                    <option value="raskhodnik">Расходник</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-8">
                            <div class="mb-3">
                                <label>Наименование</label>
                                <input v-model="name" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label>Артикул</label>
                                <input v-model="artnumber" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="mb-3">
                                <label>Производитель</label>
                                <input v-model="brand" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-lg-2">
                            <div class="mb-3">
                                <label>Себестоимость</label>
                                <input v-model="costPrice" type="number" min="0" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-lg-2">
                            <div class="mb-3">
                                <label>Кол-во</label>
                                <input v-model="quantity" type="number" min="0" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" :disabled="views.submitButton == false" class="btn btn-lg btn-primary">Сохранить</button>
        </form>

        <div class="card border-bottom-primary shadow py-2 mt-4 mb-4">
            <div class="card-body">
                <h5>Поступления</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Количество</th>
                            <th>Стоимость</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="balanceItem in nomenclature.stock_balance_items">
                            <td>
                                {{ balanceItem.date | date }}
                            </td>
                            <td>
                                {{ balanceItem.quantity }}
                            </td>
                            <td>
                                {{ balanceItem.price | currency }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import Loader from '../Loader.vue'

    export default {
        data() {
            return {
                nomenclature: {},
                
                uid: '',
                artnumber: '',
				name: '',
                brand: '',
                costPrice: 0,
                quantity: 0,
                isActive: true,

                selected: {
                    type: 'tovar',
                },

                views: {
                    loading: true,
					saveButton: true,
                }				
            }
        },
        created() {
            this.loadNomenclature()
        },
		methods: {
            loadNomenclature() {
                axios.get(`/api/nomenclature/${this.$route.params.uid}`)
                .then(response => {
                    this.nomenclature = response.data

                    this.uid = response.data.uid
                    this.artnumber = response.data.artnumber
				    this.name = response.data.name
                    this.brand = response.data.brand
                    this.costPrice = response.data.cost_price
                    this.quantity = response.data.quantity
                    this.isActive = response.data.is_active
                    this.selected.type = response.data.type

                    this.$parent.views.title = this.name

                    this.views.loading = false
                })
                .catch(errors => {
                    this.$swal({
                        text: 'Ошибка',
                        icon: 'error',
                    })
                })
            },
			update() {
                let user = this.$parent.user

                if(!user) {
                    return this.$swal({
                        text: 'Пользователь не найден',
                        icon: 'error',
                    })
                }

				this.views.saveButton = false
                
                axios.put(`/api/nomenclature/${this.uid}/update`, {
                    user: user.uid,
                    type: this.selected.type,
                    artnumber: this.artnumber,
                    name: this.name,
                    brand: this.brand,
                    cost_price: this.costPrice,
                    quantity: this.quantity,
                    is_active: this.isActive,
                })
                .then(response => {
                    this.$router.push({name: 'Nomenclatures'})
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

<style scoped>
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
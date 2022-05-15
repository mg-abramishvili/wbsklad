<template>
    <div class="nomenclatures-pages">
        <div class="mb-4">
            <router-link :to="{name: 'Nomenclatures'}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left mr-2"></i>
                Назад к списку номенклатуры
            </router-link>
        </div>

        <form @submit.prevent="save" class="very-big flex">
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
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label>Артикул</label>
                                <input v-model="artnumber" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="mb-3">
                                <label>Производитель</label>
                                <input v-model="brand" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-lg-2">
                            <div class="mb-3">
                                <label>Размер</label>
                                <input v-model="tech_size" type="text" class="form-control">
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
    </div>
</template>

<script>
    import Loader from '../Loader.vue'

    export default {
        data() {
            return {
                artnumber: '',
				name: '',
                brand: '',
                tech_size: '',
                costPrice: 0,
                quantity: 0,
                isActive: true,

                selected: {
                    type: 'tovar',
                },

                views: {
                    loading: false,
					saveButton: true,
                }				
            }
        },
        created() {
            this.$parent.views.title = 'Новая номенклатура'
        },
		methods: {
			save() {
                let user = this.$parent.user

                if(!user) {
                    return this.$swal({
                        text: 'Пользователь не найден',
                        icon: 'error',
                    })
                }

				this.views.saveButton = false
                
                axios.post(`/api/nomenclatures`, {
                    user: user.uid,
                    type: this.selected.type,
                    artnumber: this.artnumber,
                    name: this.name,
                    brand: this.brand,
                    tech_size: this.tech_size,
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
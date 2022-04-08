<template>
    <div class="add-site-form">
        <div class="top-block flex">
            <p>
                <router-link :to="{name: 'Nomenclatures'}">&larr; Назад</router-link>
                Новая позиция в номенклатуру
            </p>
        </div>
        <form @submit.prevent="save" class="very-big flex">
            <div class="block">
                <div class="field-name">
                    Тип
                </div>
                <select v-model="selected.type">
                    <option value="tovar">Товар</option>
                    <option value="usluga">Услуга</option>
                    <option value="raskhodnik">Расходник</option>
                </select>

                <div class="field-name">
                    Наименование
                </div>
                <input v-model="name" type="text">

                <div class="field-name">
                    Артикул
                </div>
                <input v-model="artnumber" type="text">

                <div class="field-name">
                    Производитель
                </div>
                <input v-model="brand" type="text">

                <button type="submit" :disabled="views.submitButton == false" class="other">Сохранить</button>
            </div>
            <div class="vline"></div>
            <div class="block">
                <div class="field-name">
                    Себестоимость
                </div>
                <input v-model="costPrice" type="number" min="0">

                <div class="field-name">
                    Количество
                </div>
                <input v-model="quantity" type="number" min="0">
            </div>
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
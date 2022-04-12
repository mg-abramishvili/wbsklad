<template>
    <div class="add-site-form">
        <div class="top-block flex">
            <p>
                <router-link :to="{name: 'Contractors'}">&larr; Назад</router-link>
                Новый контрагент
            </p>
        </div>
        <form @submit.prevent="save" class="very-big flex">
            <div class="block">
                <div class="field-name">
                    Название
                </div>
                <input v-model="name" type="text">

                <div class="field-name">
                    ИНН
                </div>
                <input v-model="inn" type="text">

                <div class="field-name">
                    КПП
                </div>
                <input v-model="kpp" type="text">

                <div class="field-name">
                    ОГРН
                </div>
                <input v-model="ogrn" type="text">

                <div class="field-name">
                    Юридический адрес
                </div>
                <input v-model="yur_address" type="text">

                <div class="field-name">
                    Почтовый адрес
                </div>
                <input v-model="pocht_address" type="text">

                <div class="field-name">
                    Фактический адрес
                </div>
                <input v-model="fakt_address" type="text">

                <div class="field-name">
                    Расчетный счет
                </div>
                <input v-model="ras_schet" type="text">

                <div class="field-name">
                    Корр.счет
                </div>
                <input v-model="korr_schet" type="text">

                <div class="field-name">
                    Банк
                </div>
                <input v-model="bank" type="text">

                <div class="field-name">
                    БИК
                </div>
                <input v-model="bik" type="text">

                <button type="submit" :disabled="views.submitButton == false" class="other">Сохранить</button>
            </div>
            <div class="vline"></div>
            <div class="block">
                <div class="field-name">
                    Телефон
                </div>
                <input v-model="tel" type="text">

                <div class="field-name">
                    E-mail
                </div>
                <input v-model="email" type="text">

                <div class="field-name">
                    Контактное лицо
                </div>
                <input v-model="kont_litso" type="text">
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: '',
                tel: '',
                email: '',
                kont_litso: '',
                yur_address: '',
                pocht_address: '',
                fakt_address: '',
                inn: '',
                kpp: '',
                ogrn: '',
                ras_schet: '',
                korr_schet: '',
                bank: '',
                bik: '',

                views: {
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

                if(!this.name) {
                    return this.$swal({
                        text: 'Укажите контрагента',
                        icon: 'error',
                    })
                }

				this.views.saveButton = false
                
                axios.post(`/api/contractors`, {
                    user: user.uid,
                    name: this.name,
                    tel: this.tel,
                    email: this.email,
                    kont_litso: this.kont_litso,
                    yur_address: this.yur_address,
                    pocht_address: this.pocht_address,
                    fakt_address: this.fakt_address,
                    inn: this.inn,
                    kpp: this.kpp,
                    ogrn: this.ogrn,
                    ras_schet: this.ras_schet,
                    korr_schet: this.korr_schet,
                    bank: this.bank,
                    bik: this.bik,
                })
                .then(response => {
                    this.$router.push({name: 'Contractors'})
                })
                .catch(error => {
                    this.$swal({
                        text: 'Ошибка',
                        icon: 'error',
                    })
                })
            },
		},
    }
</script>
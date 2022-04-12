<template>
    <Loader v-if="views.loading" />

    <div v-else class="add-site-form">
        <div class="top-block flex">
            <p>
                <router-link :to="{name: 'Contractors'}">&larr; Назад</router-link>
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
    import Loader from '../Loader'

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
                    loading: true,
					saveButton: true,
                }				
            }
        },
        created() {
            this.loadContractor()
        },
		methods: {
            loadContractor() {
                axios.get(`/api/contractor/${this.$route.params.uid}`)
                .then(response => {
                    this.name = response.data.name
                    this.tel = response.data.tel
                    this.email = response.data.email
                    this.kont_litso = response.data.kont_litso
                    this.yur_address = response.data.yur_address
                    this.pocht_address = response.data.pocht_address
                    this.fakt_address = response.data.fakt_address
                    this.inn = response.data.inn
                    this.kpp = response.data.kpp
                    this.ogrn = response.data.ogrn
                    this.ras_schet = response.data.ras_schet
                    this.korr_schet = response.data.korr_schet
                    this.bank = response.data.bank
                    this.bik = response.data.bik

                    this.views.loading = false
                })
                .catch(errors => {
                    this.$swal({
                        text: 'Ошибка',
                        icon: 'error',
                    })
                })
            },
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
                
                axios.put(`/api/contractor/${this.$route.params.uid}/update`, {
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
        components: {
            Loader
        }
    }
</script>
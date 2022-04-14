<template>
    <div class="contractors-page">
        <div class="mb-4">
            <router-link :to="{name: 'Contractors'}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left mr-2"></i>
                Назад к списку контрагентов
            </router-link>
        </div>
        
        <form @submit.prevent="save">
            <div class="row">
                <div class="col-12 col-lg-7">
                    <div class="card border-bottom-primary shadow py-2 mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label>Название</label>
                                        <input v-model="name" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="mb-3">
                                        <label>ИНН</label>
                                        <input v-model="inn" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="mb-3">
                                        <label>КПП</label>
                                        <input v-model="kpp" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="mb-3">
                                        <label>ОГРН</label>
                                        <input v-model="kpp" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label>Юридический адрес</label>
                                        <input v-model="yur_address" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label>Почтовый адрес</label>
                                        <input v-model="pocht_address" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-0">
                                        <label>Фактический адрес</label>
                                        <input v-model="fakt_address" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-bottom-primary shadow py-2 mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="mb-3">
                                        <label>Расчетный счет</label>
                                        <input v-model="ras_schet" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="mb-3">
                                        <label>Корр. счет</label>
                                        <input v-model="korr_schet" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="mb-0">
                                        <label>БИК</label>
                                        <input v-model="bik" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="mb-0">
                                        <label>Банк</label>
                                        <input v-model="bank" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="card border-bottom-primary shadow py-2 mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <label>Контактное лицо</label>
                                <input v-model="kont_litso" type="text" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Телефон</label>
                                <input v-model="tel" type="text" class="form-control">
                            </div>
                            <div class="mb-0">
                                <label>E-mail</label>
                                <input v-model="email" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <button type="submit" :disabled="views.submitButton == false" class="btn btn-lg btn-primary">Сохранить</button>
                    </div>
                </div>
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
        created() {
            this.$parent.views.title = 'Новый контрагент'
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
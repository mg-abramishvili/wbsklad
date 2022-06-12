<template>
    <Loader v-if="views.loading"></Loader>

    <div v-else class="contractors-page">
        <form @submit.prevent="update">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="card border-bottom-primary shadow py-2 mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label>Имя</label>
                                        <input v-model="name" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label>E-mail</label>
                                        <input v-model="email" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="card border-bottom-primary shadow py-2 mb-4">
                        <div class="card-body">
                            <div class="mb-0">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <label>API-ключ (x64)</label>
                                    </div>
                                    <div class="col-6 text-right">
                                        <label @click="openKeyHelpModal()" style="color: #3699ff; font-weight: 500; cursor: pointer;">Где найти мой API-ключ?</label>
                                    </div>
                                </div>
                                <input v-model="wbApiKey" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <button type="submit" :disabled="views.submitButton == false" class="btn btn-lg btn-primary">Сохранить изменения</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    import Loader from '../Loader.vue'

    export default {
        data() {
            return {
                name: '',
				email: '',

                wbApiKey: '',
                
				errors: [],

                views: {
                    loading: true,
					submitButton: true,
                    success: false,
                    modals: {
                        keyHelp: false,
                    },
                }				
            }
        },
        computed: {
            ...mapGetters(['user']),
        },
        created() {
            this.$parent.views.title = 'Настройки'

            this.loadUser()
        },
		methods: {
            loadUser() {                
                this.name = this.user.name
                this.email = this.user.email
                this.wbApiKey = this.user.settings.wb_api_key

                this.views.loading = false
            },
			update() {
                this.views.submitButton = false
                
                axios.put(`/api/user/update`, {
                    user: this.user.uid,
                    name: this.name,
                    email: this.email,
                    wb_api_key: this.wbApiKey,
                })
                .then(response => {
                    window.location.href = '/settings'
                })
                .catch(error => {
                    this.$swal({
                        text: 'Ошибка',
                        icon: 'error',
                    })
                })
            },
            openKeyHelpModal() {
                this.views.modals.keyHelp = true

                this.$swal({
                    position: 'top-center',
                    imageUrl: '/img/keyHelp.png',
                    customClass: 'swal-wide',
                })
            },
            closeKeyHelpModal() {
                this.views.modals.keyHelp = false
            },
		},
        components: {
            Loader
        }
    }
</script>
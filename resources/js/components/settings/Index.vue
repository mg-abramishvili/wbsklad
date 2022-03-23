<template>
    <Loader v-if="views.loading"></Loader>

    <div v-else class="add-site-form">
        <div class="top-block flex">
            <p>Личная информация</p>
            <div class="buttons other">
                <button>Мой профиль</button>
                <button>Уведомления</button>
                <button>Настройки</button>
            </div>
        </div>
        <form @submit.prevent="update" class="very-big flex">
            <div class="block">
                <div class="top-text">
                    Контактная информация
                </div>

                <div class="field-name">
                    Имя
                </div>
                <input v-model="name" type="text">

                <div class="field-name">
                    E-mail
                </div>
                <input v-model="email" type="text">

                <button type="submit" :disabled="views.submitButton == false" class="other">Сохранить изменения</button>

                <div v-if="views.success" style="color: green; display: inline-block; vertical-align: middle; margin-left: 20px;">
                    Профиль обновлен!
                </div>
            </div>
            <div class="vline"></div>
            <div class="block">
                <div class="top-text">
                    Подключение к Wildberries
                </div>

                <div class="field-name">
                    API-ключ
                </div>
                <input v-model="wbApiKey" type="text">
            </div>
        </form>
    </div>
</template>

<script>
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
                }				
            }
        },
        created() {
            this.loadUser()
        },
		methods: {
            loadUser() {
                let user = this.$parent.user

                if(!user) {
                    return this.$swal({
                        text: 'Пользователь не найден',
                        icon: 'error',
                    })
                }
                
                this.name = user.name
                this.email = user.email
                this.wbApiKey = user.settings.wb_api_key

                this.views.loading = false
            },
			update() {
                let user = this.$parent.user

                if(!user) {
                    return this.$swal({
                        text: 'Пользователь не найден',
                        icon: 'error',
                    })
                }

				this.views.submitButton = false
                
                axios.put(`/api/user/${user.uid}/update`, {
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
		},
        components: {
            Loader
        }
    }
</script>
<template>
    <div class="add-site-form small2 registration-form">
        <div class="top-block flex">
            <p>WBSklad</p>
        </div>
        <form @submit.prevent="login">
            <ul v-if="errors.length" class="errors">
                <li v-for="error in errors" class="error-message">
                    {{ error }}
                </li>
            </ul>
            <div class="flex">
                <div class="col">
                    <div class="field-name">
                        Логин
                    </div>
                    <input type="email" v-model="formData.email">
                </div>
                <div class="col">
                    <div class="field-name">
                        Пароль
                    </div>
                    <input type="password" v-model="formData.password">
                </div>
            </div>
            <div class="buttons">
                <button type="submit" :disabled="views.submitButton == false">
                    Войти
                </button>
                <router-link :to="{name: 'Registration'}">
                    Регистрация
                </router-link>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
				formData: {
                    email: '',
                    password: ''
                },
                
				errors: [],

                views: {
					submitButton: true,
                }				
            }
        },
		methods: {
			login() {
                this.errors = []

				this.views.submitButton = false
                
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('/api/login', this.formData)
                    .then(response => {
						window.location.href = "/"
                    })
                    .catch((error) => {
                        this.errors.push(error.response.data)
                        this.views.submitButton = true
                    })
                })
            },
		},
    }
</script>
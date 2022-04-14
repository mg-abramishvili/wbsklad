<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-12 col-md-6">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">WBSKLAD.RU</h1>
                                    </div>

                                    <ul v-if="errors.length" class="p-0 m-0 errors">
                                        <div v-for="error in errors" class="alert alert-danger" role="alert">
                                            {{ error }}
                                        </div>
                                    </ul>

                                    <form @submit.prevent="login" class="user">
                                        <div class="form-group">
                                            <input type="email" v-model="formData.email" class="form-control form-control-user" placeholder="E-mail">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" v-model="formData.password" class="form-control form-control-user" placeholder="Пароль">
                                        </div>

                                        <button type="submit" :disabled="views.submitButton == false" class="btn btn-primary btn-user btn-block">
                                            Войти
                                        </button>
                                        <div class="text-center mt-2">
                                            <router-link :to="{name: 'Registration'}">
                                                Регистрация
                                            </router-link>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
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
                                        <h1 class="h4 text-gray-900 mb-4">Регистрация на WBSKLAD.RU</h1>
                                    </div>

                                    <ul v-if="errors.length" class="p-0 m-0 errors">
                                        <div v-for="error in errors" class="alert alert-danger" role="alert">
                                            {{ error }}
                                        </div>
                                    </ul>

                                    <form @submit.prevent="registration" class="user">
                                        <div class="form-group">
                                            <input type="text" v-model="name" class="form-control form-control-user" placeholder="Имя">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" v-model="email" class="form-control form-control-user" placeholder="E-mail">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" v-model="passwordOne" class="form-control form-control-user" placeholder="Пароль">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" v-model="passwordTwo" class="form-control form-control-user" placeholder="Пароль еще раз">
                                        </div>
                                        
                                        <button type="submit" :disabled="views.submitButton == false" class="btn btn-primary btn-user btn-block">
                                            Зарегистрироваться
                                        </button>

                                        <div class="text-center mt-2">
                                            <router-link :to="{name: 'Login'}">
                                                Вернуться к форме входа
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
                name: '',
                email: '',

                passwordOne: '',
                passwordTwo: '',
                
				errors: [],

                views: {
					submitButton: true,
                }				
            }
        },
        computed: {
            password() {
                if(this.passwordOne == this.passwordTwo) {
                    return this.passwordOne
                }
            }
        },
		methods: {
			registration() {
                this.errors = []

                if(!this.name) {
                    return this.errors.push('Укажите имя')
                }
                if(!this.email) {
                    return this.errors.push('Укажите E-mail')
                }
                if(!this.emailValidation(this.email)) {
                    return this.errors.push('Неверный формат E-mail')
                }
                if(!this.password) {
                    return this.errors.push('Не указан пароль или пароли не совпадают')
                }

				this.views.submitButton = false

                axios.post('/api/registration', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                })
                .then(response => {
                    this.$router.push({name: 'Login'})
                })
                .catch((error) => {
                    this.errors.push(error.response.data)
                    this.views.submitButton = true
                })
            },
            emailValidation(email) {
                let format = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                
                if(email.match(format)) {
                    return true
                } else {
                    return false
                }
            }
		},
    }
</script>
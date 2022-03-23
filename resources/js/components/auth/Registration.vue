<template>
    <div class="add-site-form small2 login-form">
        <div class="top-block flex">
            <p>
                <router-link :to="{name: 'Login'}">&larr;</router-link>
                Регистрация на WBSklad
            </p>
        </div>
        <form @submit.prevent="registration">
            <ul v-if="errors.length" class="errors">
                <li v-for="error in errors" class="error-message">
                    {{ error }}
                </li>
            </ul>
            <div class="flex">
                <div class="col">
                    <div class="field-name">
                        Имя
                    </div>
                    <input type="text" v-model="name">
                </div>
                <div class="col">
                    <div class="field-name">
                        E-mail
                    </div>
                    <input type="text" v-model="email">
                </div>
                <div class="col">
                    <div class="field-name">
                        Пароль
                    </div>
                    <input type="password" v-model="passwordOne">
                </div>
                <div class="col">
                    <div class="field-name">
                        Пароль еще раз
                    </div>
                    <input type="password" v-model="passwordTwo">
                </div>
            </div>
            <div class="buttons">
                <button type="submit" :disabled="views.submitButton == false">
                    Регистрация
                </button>
            </div>
        </form>
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
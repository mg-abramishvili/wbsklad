<template>
	<div v-if="views.loading == false" class="wrapper">
		<template v-if="authenticated == true">
			<div class="main">
				<router-view :key="$route.path" />
			</div>
		</template>

		<div v-if="authenticated == false" id="auth_form" class="main d-flex justify-content-center w-100" style="margin-left: 0;">
			<main class="content d-flex p-0">
				<div class="container d-flex flex-column">
					<div class="row h-100">
						<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
							<div class="d-table-cell align-middle">

								<div class="text-center mt-4 mb-4">
									<h1 class="h2">WBSklad</h1>
								</div>

								<div class="card">
									<div class="card-body">
										<div class="m-sm-4">
											<form @submit.prevent="handleLogin">
												<div v-if="errors.length" class="alert alert-danger alert-dismissible" role="alert">
													<div v-for="error in errors" class="alert-message">
														{{ error }}
													</div>
												</div>
												<div class="mb-3">
													<label class="form-label">E-mail</label>
													<input type="email" name="email" ref="email" class="form-control form-control-lg" v-model="formData.email" placeholder="">
												</div>
												<div class="mb-3">
													<label class="form-label">Пароль</label>
													<input type="password" name="password" class="form-control form-control-lg" v-model="formData.password" placeholder="">
												</div>
												<div class="text-center mt-3">

													<button class="btn btn-lg btn-primary" type="submit" :disabled="views.submitButton == false">
														<span v-if="views.submitButton == false" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
														Войти
													</button>
												</div>
											</form>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</main>
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
                
                user: {},

                authenticated: false,
                
				errors: [],

                views: {
                    sidebar: true,
                    loading: true,
					submitButton: true,
                }				
            }
        },
        created() {
			this.checkMe()
        },
		methods: {
			handleLogin() {
				this.views.submitButton = false
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('/api/login', this.formData).then(response => {
						if(response.data === 'bad_login') {
                            this.errors = []
							this.errors.push('Неверный E-mail или пароль')
							this.views.submitButton = true
						} else {
							this.checkMe()
							// this.views.submitButton = true
						}
                    })
                });
            },
			checkMe() {
				axios.post('/api/me').then(response => {
					this.user = response.data
					if(this.user.name && this.user.name.length) {
						this.authenticated = true
                        this.views.loading = false
					} else {
						this.authenticated = false
                        this.views.loading = false
						setTimeout(() => {
							if(this.$refs.email) {
								this.$refs.email.focus()
							}
						}, 100);
						
					}
				})
			},
		},
    }
</script>
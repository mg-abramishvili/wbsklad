<template>
	<div v-if="!views.loading" id="wrapper">
		<template v-if="authenticated">
			<Sidebar></Sidebar>

			<div id="content-wrapper" class="d-flex flex-column">
				<div id="content">
					<Header :title="views.title"></Header>

					<div class="container-fluid">
						<router-view :key="$route.path" />
					</div>
				</div>

				<footer class="sticky-footer bg-white">
					<div class="container my-auto">
						<div class="copyright text-center my-auto">
							<span>2022 © WBSKLAD.RU</span>
						</div>
					</div>
				</footer>
			</div>
		</template>

		<template v-if="!authenticated">
			<router-view :key="$route.path" />
		</template>
	</div>
</template>

<script>
	import Sidebar from './components/Sidebar.vue'
	import Header from './components/Header.vue'

    export default {
        data() {
            return {                
                user: {},

                authenticated: false,

                views: {
					title: '',
                    loading: true,
                }				
            }
        },
        created() {
			if(this.$route.name != 'Login' && this.$route.name != 'Registration' && this.$route.name != 'UserVerify') {
				this.checkMe()
			} else {
				this.views.loading = false
			}
        },
		methods: {
			checkMe() {
				axios.post('/api/me').then(response => {
					this.user = response.data

					if(this.user) {
						this.authenticated = true
                        this.views.loading = false
						return
					}
					
					if(!this.user) {
						this.views.loading = false

						this.$router.push({name: 'Login'})
					}
				})
			},
		},
		components: {
			Sidebar,
			Header
		}
    }
</script>
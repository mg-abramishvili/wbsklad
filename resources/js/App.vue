<template>
	<div v-if="!views.loading" class="app">
		<template v-if="authenticated">
			<Sidebar></Sidebar>

			<div class="site-content">
				<Header></Header>
				
				<div class="wrap">
					<router-view :key="$route.path" />
				</div>
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
                    sidebar: true,
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
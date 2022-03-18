<template>
	<div v-if="views.loading == false" class="app">
		<template v-if="authenticated == true">
			<Sidebar></Sidebar>

			<div class="site-content">
				<Header></Header>
				
				<div class="wrap">
					<router-view :key="$route.path" />
				</div>
			</div>
		</template>

		<Login v-if="authenticated == false"></Login>
	</div>
</template>

<script>
	import Login from './Login.vue'
	import Sidebar from './Sidebar.vue'
	import Header from './Header.vue'

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
			this.checkMe()
        },
		methods: {
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
		components: {
			Login,
			Sidebar,
			Header
		}
    }
</script>
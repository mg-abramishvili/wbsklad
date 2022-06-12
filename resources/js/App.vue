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
	import { mapGetters, mapActions, mapMutations } from 'vuex'
	import Sidebar from './components/Sidebar.vue'
	import Header from './components/Header.vue'

    export default {
        data() {
            return {
				authenticated: false,
				
                views: {
					title: '',
					loading: true,
                }				
            }
        },
		computed: {
			...mapGetters(['user']),
		},
		methods: {
			...mapActions(['loadUser']),
			...mapMutations(['setUser']),

			checkMe() {
				this.loadUser().then(response => {
					if(response) {
						this.setUser(response)
						this.authenticated = true
                        this.views.loading = false
						return
					}
					if(!response) {
						this.views.loading = false
						this.$router.push({name: 'Login'})
					}
				})
			}
		},
		created() {
			if(this.$route.name != 'Login' && this.$route.name != 'Registration' && this.$route.name != 'UserVerify') {
				this.checkMe()
			} else {
				this.views.loading = false
			}
        },
		components: {
			Sidebar,
			Header
		}
    }
</script>
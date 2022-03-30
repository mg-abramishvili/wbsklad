<template>
    <div class="add-site-form small2 registration-form">
        <div class="top-block flex">
            <p>WBSklad</p>
        </div>

        <ul v-if="errors.length" class="errors">
            <li v-for="error in errors" class="error-message">
                {{ error }}
            </li>
        </ul>

        <p v-if="views.success">E-mail успешно подтвержден!</p>
    </div>
</template>

<script>
    export default {
        data() {
            return {                
				errors: [],
                
                views: {
                    success: false,
                }
            }
        },
        created() {
            this.checkUserVerifyKey()
        },
		methods: {
			checkUserVerifyKey() {
                this.errors = []
                
                axios.get(`/api/user-verify/${this.$route.params.key}`)
                .then(response => {
                    this.views.success = true

                    setTimeout(() => {
                        window.location.href = '/login'
                    }, 2000)
                })
                .catch(errors => {
                    this.errors.push('Что-то пошло не так')
                })
            },
		},
    }
</script>
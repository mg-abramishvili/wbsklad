<template>
    <div class="home-page">
        <h1>Home page</h1>

        <router-link :to="{name: 'Reports'}">Отчеты</router-link>
    </div>
</template>
<script>
    import Loader from './Loader.vue'

    export default {
        data() {
            return {
                //
            }
        },
        created() {
            //
        },
        methods: {
            //
        },
        components: {
            Loader
        }
    }
</script>
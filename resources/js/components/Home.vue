<template>
    <div class="home-page">
        <h5>Добро пожаловать</h5>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                //
            }
        },
        created() {
            this.$parent.views.title = 'Главная страница WBSKLAD.RU'
        },
    }
</script>
<template>
    <div class="prices-list reports-page">
        <h1>Отчеты</h1>

        <router-link :to="{name: 'Home'}">Назад</router-link>

        <table>
            <tbody>
                <tr v-for="(reportItem, index) in reports" :key="reportItem.nm_id">
                    <td>
                        {{ index }}
                    </td>
                    <td>
                        {{ reportItem }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    import Loader from '../Loader.vue'

    export default {
        data() {
            return {
                reports: [],

                views: {
                    loading: false,
                }
            }
        },
        created() {
            this.loadReports()
        },
        methods: {
            loadReports() {
                axios
                .get(`https://suppliers-stats.wildberries.ru/api/v1/supplier/reportDetailByPeriod?dateFrom=2022-02-01&key=ODE5NTA1ZjItNDJkYi00NGM0LWJkZjMtYTg4NGZhMzFjMzU0&limit=1000&rrdid=0&dateto=2022-03-01`)
                .then(response => (
                    this.reports = response.data,
                    this.views.loading = false
                ));
            },
        },
        components: {
            Loader
        }
    }
</script>
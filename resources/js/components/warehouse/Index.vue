<template>
    <div class="prices-list reports-page">
        <Loader v-if="views.loading" />

        <table v-if="!views.loading">
            <tbody>
                <tr v-for="(reportItem, index) in reports" :key="reportItem.nm_id">
                    <td>
                        {{ index + 1 }}
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

                token: 'ODE5NTA1ZjItNDJkYi00NGM0LWJkZjMtYTg4NGZhMzFjMzU0',

                views: {
                    loading: true,
                }
            }
        },
        created() {
            this.loadReports()
        },
        methods: {
            loadReports() {
                axios
                .get(` https://suppliers-stats.wildberries.ru/api/v1/supplier/stocks?dateFrom=2022-02-01T21%3A00%3A00.000Z&key=${this.token}`)
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
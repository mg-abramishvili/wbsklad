<template>
    <div>
        <div class="prices-list">
            <div class="top-block flex">
                <p>Контрагенты</p>
                <div class="buttons">
                    <button>Добавить</button>
                </div>
            </div>

            <div v-if="contractors.length" class="table-wrapper">
                <table class="other">
                    <thead>
                        <tr>
                            <td>ФИО / ИП / ООО</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ contractor.name }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p v-else>Нет контрагентов.</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            contractors: [],

            views: {
                loading: true,
            },
        }
    },
    created() {
        this.loadContractors()
    },
    methods: {
        loadContractors() {
            axios.get(`/api/user/${this.$parent.user.uid}/contractors`)
            .then(response => {
                this.contractors = response.data
            })
        }
    }
}
</script>

<template>
    <div>
        <div class="prices-list">
            <div class="top-block flex">
                <p>Контрагенты</p>
                <div class="buttons">
                    <router-link :to="{name: 'ContractorCreate'}">Добавить</router-link>
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
                        <tr v-for="contractor in contractors">
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
            let user = this.$parent.user

            if(!user) {
                return
            }

            axios.get(`/api/contractors`, { params: { user: user.uid } })
            .then(response => {
                this.contractors = response.data
            })
        }
    }
}
</script>

<template>
    <div class="prices-list warehouse-page">
        <div class="top-block flex">
            <p>Список товаров</p>
            <div class="buttons other">
                <form>
                    <input type="text" placeholder="Поиск">
                </form>
                <button>Добавить товар</button>
            </div>
        </div>

        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="table-wrapper">
            <table class="other">
                <thead>
                    <tr>
                        <th></th>
                        <th>Код WB</th>
                        <th>Предмет</th>
                        <th>Категория</th>
                        <th>Бренд</th>
                        <th>Артикул</th>
                        <th>Размер</th>
                        <th>Штрихкод</th>
                        <th>Кол-во для продажи</th>
                        <th>Кол-во полное</th>
                        <th>Кол-во не в заказе</th>
                        <th>Договор поставки</th>
                        <th>Договор реализации</th>
                        <th>Код контракта</th>
                        <th>Название склада</th>
                        <th>В пути к клиенту</th>
                        <th>В пути от клиента</th>
                        <th>Дней на сайте</th>
                        <th>Обновлено</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in items" :key="item.nm_id">
                        <td>
                            {{ index + 1 }}
                        </td>
                        <td>
                            {{ item.nmId }}
                        </td>
                        <td>
                            {{ item.subject }}
                        </td>
                        <td>
                            {{ item.category }}
                        </td>
                        <td>
                            {{ item.brand }}
                        </td>
                        <td>
                            {{ item.supplierArticle }}
                        </td>
                        <td>
                            {{ item.techSize }}
                        </td>
                        <td>
                            {{ item.barcode }}
                        </td>
                        <td>
                            {{ item.quantity }}
                        </td>
                        <td>
                            {{ item.quantityFull }}
                        </td>
                        <td>
                            {{ item.quantityNotInOrders }}
                        </td>
                        <td>
                            {{ item.isSupply }}
                        </td>
                        <td>
                            {{ item.isRealization }}
                        </td>
                        <td>
                            {{ item.SCCode }}
                        </td>
                        <td>
                            {{ item.warehouseName }}
                        </td>
                        <td>
                            {{ item.inWayToClient }}
                        </td>
                        <td>
                            {{ item.inWayFromClient }}
                        </td>
                        <td>
                            {{ item.daysOnSite }}
                        </td>
                        <td>
                            {{ item.lastChangeDate }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
    import Loader from '../Loader.vue'

    export default {
        data() {
            return {
                items: [],

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
                let token = this.$parent.user.wbtoken

                if(!token) {
                    alert('API-ключ не найден')
                    return
                }

                axios
                .get(` https://suppliers-stats.wildberries.ru/api/v1/supplier/stocks?dateFrom=2022-02-01T21%3A00%3A00.000Z&key=${token}`)
                .then(response => (
                    this.items = response.data,
                    this.views.loading = false
                ));
            },
        },
        components: {
            Loader
        }
    }
</script>
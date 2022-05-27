<template>
    <div class="realizationreports-page">
        <div class="mb-4">
            <router-link :to="{name: 'RealizationReports'}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left mr-2"></i>
                Назад к списку отчетов
            </router-link>
        </div>

        <Loader v-if="views.loading" />

        <div v-if="!views.loading" class="table-wrapper">
            <ag-grid-vue v-if="report.realization_report_items.length"
                class="ag-theme-alpine realizationreports-table"
                :defaultColDef="table.defaultColDef"
                :columnDefs="table.columns"
                @grid-ready="onGridReady"
                :rowData="table.data"
                @row-double-clicked="onRowClicked"
                enableCellTextSelection="true"
                ensureDomOrder="true"
            >
            </ag-grid-vue>

            <p v-else class="text-muted">Пусто.</p>
        </div>
    </div>
</template>

<script>
import Loader from '../Loader.vue'

import { AgGridVue } from "ag-grid-vue";
import "ag-grid-community/dist/styles/ag-grid.css";
import "ag-grid-community/dist/styles/ag-theme-alpine.css";

export default {
    data() {
        return {
            report: {},

            table: {
                data: [],
                columns: [
                    { field: "subject_name", headerName: 'Предмет', width: 200 },
                    { field: "rr_dt", headerName: 'Дата операции' },
                    { field: "nm_id", headerName: 'Артикул' },
                    { field: "brand_name", headerName: 'Бренд' },
                    { field: "sa_name", headerName: 'Артикул поставщика' },
                    { field: "ts_name", headerName: 'Размер' },
                    { field: "barcode", headerName: 'Баркод' },
                    { field: "doc_type_name", headerName: 'Тип документа' },
                    { field: "quantity", headerName: 'Количество' },
                    { field: "retail_price", headerName: 'Цена розничная' },
                    { field: "retail_amount", headerName: 'Сумма продаж (возвратов)' },
                    { field: "sale_percent", headerName: 'Согласованная скидка' },
                    { field: "commission_percent", headerName: 'Процент комиссии' },
                    { field: "office_name", headerName: 'Склад' },
                    { field: "supplier_oper_name", headerName: 'Обоснование для оплаты' },
                    { field: "order_dt", headerName: 'Даты заказа' },
                    { field: "sale_dt", headerName: 'Дата продажи' },
                    { field: "shk_id", headerName: 'ШК' },
                    { field: "retail_price_withdisc_rub", headerName: 'Цена розничная с учетом согласованной скидки' },
                    { field: "delivery_amount", headerName: 'Кол-во доставок' },
                    { field: "return_amount", headerName: 'Кол-во возвратов' },
                    { field: "delivery_rub", headerName: 'Стоимость логистики' },
                    { field: "gi_box_type_name", headerName: 'Тип коробов' },
                    { field: "product_discount_for_report", headerName: 'Согласованный продуктовый дисконт' },
                    { field: "supplier_promo", headerName: 'Промокод' },
                    { field: "ppvz_spp_prc", headerName: 'Скидка постоянного Покупателя (СПП)' },
                    { field: "ppvz_kvw_prc_base", headerName: 'Размер кВВ без НДС, % Базовый' },
                    { field: "ppvz_kvw_prc", headerName: 'Итоговый кВВ без НДС, %' },
                    { field: "ppvz_sales_commission", headerName: 'Вознаграждение с продаж до вычета услуг поверенного, без НДС' },
                    { field: "ppvz_for_pay", headerName: 'К перечислению Продавцу за реализованный Товар' },
                    { field: "ppvz_reward", headerName: 'Возмещение Расходов услуг поверенного' },
                    { field: "ppvz_vw", headerName: 'Вознаграждение Вайлдберриз (ВВ), без НДС' },
                    { field: "ppvz_vw_nds", headerName: 'НДС с Вознаграждения Вайлдберриз' },
                    { field: "ppvz_office_id", headerName: 'Номер офиса' },
                    { field: "ppvz_office_name", headerName: 'Наименование офиса доставки' },
                    { field: "ppvz_supplier_id", headerName: 'Номер партнера' },
                    { field: "ppvz_supplier_name", headerName: 'Партнер' },
                    { field: "ppvz_inn", headerName: 'ИНН партнера' },
                    { field: "declaration_number", headerName: 'Номер таможенной декларации' },
                    { field: "bonus_type_name", headerName: 'Обоснование штрафов и доплат' },
                    { field: "suppliercontract_code", headerName: 'Договор' },
                ],
                defaultColDef: {
                    movable: false,
                    suppressMovable: true,
                    suppressRowClickSelection: true,
                },
            },

            views: {
                loading: true,
            },
        }
    },
    created() {
        this.$parent.views.title = this.report.id

        this.loadRealizationReport()
    },
    methods: {
        loadRealizationReport() {
            axios.get(`/api/realization-report/${this.$route.params.id}`)
            .then(response => {
                this.report = response.data
                this.table.data = response.data.realization_report_items
                this.views.loading = false
            })
            .catch(error => {
                this.$swal({
                    text: error,
                    icon: 'error',
                })
            })
        },
        onGridReady(params) {
            this.gridApi = params.api
            this.gridColumnApi = params.gridColumnApi
        },
        onRowClicked(event) {
            // this.$router.push({name: 'RealizationReport', params: {uid: event.data.uid}})
        },
    },
    components: {
        Loader,
        AgGridVue
    }
}
</script>
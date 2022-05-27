<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealizationReportItemsTable extends Migration
{
    public function up()
    {
        Schema::create('realization_report_items', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('realizationreport_id');
            $table->string('suppliercontract_code')->nullable();
            $table->string('rrd_id');
            $table->integer('gi_id')->nullable();
            $table->string('subject_name');
            $table->integer('nm_id');
            $table->string('brand_name')->nullable();
            $table->string('sa_name')->nullable();
            $table->string('ts_name')->nullable();
            $table->string('barcode');
            $table->string('doc_type_name');
            $table->integer('quantity');
            $table->decimal('retail_price');
            $table->decimal('retail_amount');
            $table->decimal('sale_percent');
            $table->decimal('commission_percent');
            $table->string('office_name');
            $table->string('supplier_oper_name');
            $table->date('order_dt');
            $table->date('sale_dt');
            $table->date('rr_dt');
            $table->string('shk_id');
            $table->decimal('retail_price_withdisc_rub');
            $table->integer('delivery_amount')->nullable();
            $table->integer('return_amount')->nullable();
            $table->decimal('delivery_rub')->nullable();
            $table->string('gi_box_type_name');
            $table->integer('product_discount_for_report');
            $table->integer('supplier_promo')->nullable();
            $table->integer('rid');
            $table->decimal('ppvz_spp_prc');
            $table->decimal('ppvz_kvw_prc_base');
            $table->decimal('ppvz_kvw_prc');
            $table->decimal('ppvz_sales_commission');
            $table->decimal('ppvz_for_pay');
            $table->decimal('ppvz_reward');
            $table->decimal('ppvz_vw');
            $table->decimal('ppvz_vw_nds');
            $table->integer('ppvz_office_id');
            $table->string('ppvz_office_name')->nullable();
            $table->integer('ppvz_supplier_id')->nullable();
            $table->string('ppvz_supplier_name')->nullable();
            $table->string('ppvz_inn')->nullable();
            $table->string('declaration_number')->nullable();
            $table->string('sticker_id')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('realization_report_items');
    }
}

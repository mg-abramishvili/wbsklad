<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuantityFieldToNomenclatureProductTable extends Migration
{
    public function up()
    {
        Schema::table('nomenclature_product', function (Blueprint $table) {
            $table->integer('quantity')->nullable();
        });
    }

    public function down()
    {
        Schema::table('nomenclature_product', function (Blueprint $table) {
            //
        });
    }
}

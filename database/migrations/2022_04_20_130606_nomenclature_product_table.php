<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NomenclatureProductTable extends Migration
{
    public function up()
    {
        Schema::create('nomenclature_product', function (Blueprint $table) {
            $table->id();
            $table->integer('nomenclature_id');
            $table->integer('product_id');
        });
    }

    public function down()
    {
        //
    }
}

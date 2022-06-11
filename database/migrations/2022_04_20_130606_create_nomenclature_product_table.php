<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNomenclatureProductTable extends Migration
{
    public function up()
    {
        Schema::create('nomenclature_product', function (Blueprint $table) {
            $table->id();
            $table->integer('nomenclature_id');
            $table->integer('product_id');
            $table->integer('quantity')->nullable();
        });
    }

    public function down()
    {
        //
    }
}

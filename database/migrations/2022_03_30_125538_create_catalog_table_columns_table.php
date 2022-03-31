<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogTableColumnsTable extends Migration
{
    public function up()
    {
        Schema::create('catalog_table_columns', function (Blueprint $table) {
            $table->id();
            $table->string('field');
            $table->string('headerName');
        });
    }

    public function down()
    {
        Schema::dropIfExists('catalog_table_columns');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCatalogTableColumnsTable extends Migration
{
    public function up()
    {
        Schema::create('user_catalog_table_columns', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('catalog_table_column_id');
            $table->integer('width')->default(200);
            $table->integer('order')->default(99);
            $table->boolean('isActive')->default(true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_catalog_table_columns');
    }
}

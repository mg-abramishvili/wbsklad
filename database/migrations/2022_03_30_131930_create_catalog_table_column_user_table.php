<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogTableColumnUserTable extends Migration
{
    public function up()
    {
        Schema::create('catalog_table_column_user', function (Blueprint $table) {
            $table->id();
            $table->integer('catalog_table_column_id');
            $table->integer('user_id');
            $table->integer('width')->default(150);
            $table->integer('order')->default(99);
        });
    }

    public function down()
    {
        Schema::dropIfExists('catalog_table_column_user');
    }
}

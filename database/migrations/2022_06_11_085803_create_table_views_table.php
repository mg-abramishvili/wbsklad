<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableViewsTable extends Migration
{
    public function up()
    {
        Schema::create('table_views', function (Blueprint $table) {
            $table->id();
            $table->integer('user_uid');
            $table->string('table_name');
            $table->longText('columns');
        });
    }

    public function down()
    {
        Schema::dropIfExists('table_views');
    }
}

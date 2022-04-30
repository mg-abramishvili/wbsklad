<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceItemsTable extends Migration
{
    public function up()
    {
        Schema::create('service_items', function (Blueprint $table) {
            $table->id();
            $table->integer('nomenclature_id');
            $table->integer('service_id');
            $table->integer('price');
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_items');
    }
}

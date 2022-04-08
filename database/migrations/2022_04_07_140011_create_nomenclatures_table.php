<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNomenclaturesTable extends Migration
{
    public function up()
    {
        Schema::create('nomenclatures', function (Blueprint $table) {
            $table->string('uid');
            $table->id();
            $table->integer('user_id');
            $table->string('type')->default('tovar');
            $table->string('artnumber');
            $table->string('name');
            $table->string('brand');
            $table->integer('cost_price')->nullable();
            $table->integer('quantity')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('nomenclatures');
    }
}

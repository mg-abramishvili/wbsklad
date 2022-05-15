<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNomenclaturesTable extends Migration
{
    public function up()
    {
        Schema::create('nomenclatures', function (Blueprint $table) {
            $table->id();
            $table->string('uid');
            $table->integer('user_id');
            $table->string('type')->default('tovar');
            $table->string('artnumber');
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('tech_size')->nullable();
            $table->decimal('cost_price')->nullable();
            $table->integer('quantity')->default(0);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('nomenclatures');
    }
}

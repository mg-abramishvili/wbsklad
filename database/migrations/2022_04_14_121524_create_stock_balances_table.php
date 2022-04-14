<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockBalancesTable extends Migration
{
    public function up()
    {
        Schema::create('stock_balances', function (Blueprint $table) {
            $table->id();
            $table->string('uid');
            $table->integer('user_id');
            $table->integer('nomenclature_id');
            $table->integer('contractor_id');
            $table->integer('quantity');
            $table->integer('price');
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_balances');
    }
}

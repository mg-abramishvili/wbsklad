<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockBalanceItemsTable extends Migration
{
    public function up()
    {
        Schema::create('stock_balance_items', function (Blueprint $table) {
            $table->id();
            $table->integer('nomenclature_id');
            $table->integer('stock_balance_id');
            $table->integer('quantity');
            $table->integer('price');
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_balance_items');
    }
}

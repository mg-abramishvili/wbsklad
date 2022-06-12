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
            $table->string('user_uid');
            $table->integer('contractor_id');
            $table->date('date');
            $table->integer('delivery_price')->nullable();
            $table->integer('delivery_contractor_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_balances');
    }
}

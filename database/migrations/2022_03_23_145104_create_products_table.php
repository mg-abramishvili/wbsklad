<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('nm_id');
            $table->string('supplier_article');
            $table->string('subject');
            $table->string('category');
            $table->string('name')->nullable();
            $table->string('brand')->nullable();
            $table->string('tech_size')->nullable();
            $table->string('barcode');
            $table->integer('price');
            $table->integer('cost_price')->nullable();
            $table->integer('quantity');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

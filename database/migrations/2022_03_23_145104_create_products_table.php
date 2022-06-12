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
            $table->string('user_uid');
            $table->string('barcode');
            $table->integer('nm_id');
            $table->string('uid');
            $table->string('supplier_article');
            $table->string('subject');
            $table->string('category');
            $table->string('name')->nullable();
            $table->string('brand')->nullable();
            $table->string('tech_size')->nullable();
            $table->decimal('price');
            $table->decimal('cost_price')->nullable();
            $table->integer('quantity')->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

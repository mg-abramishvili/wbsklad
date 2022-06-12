<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractorsTable extends Migration
{
    public function up()
    {
        Schema::create('contractors', function (Blueprint $table) {
            $table->id();
            $table->string('user_uid');
            $table->string('uid');
            $table->string('name');
            $table->string('tel')->nullable();
            $table->string('email')->nullable();
            $table->string('kont_litso')->nullable();
            $table->string('yur_address')->nullable();
            $table->string('pocht_address')->nullable();
            $table->string('fakt_address')->nullable();
            $table->string('inn')->nullable();
            $table->string('kpp')->nullable();
            $table->string('ogrn')->nullable();
            $table->string('ras_schet')->nullable();
            $table->string('korr_schet')->nullable();
            $table->string('bank')->nullable();
            $table->string('bik')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contractors');
    }
}

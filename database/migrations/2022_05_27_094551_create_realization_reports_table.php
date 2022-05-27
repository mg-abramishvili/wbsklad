<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealizationReportsTable extends Migration
{
    public function up()
    {
        Schema::create('realization_reports', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('realization_reports');
    }
}

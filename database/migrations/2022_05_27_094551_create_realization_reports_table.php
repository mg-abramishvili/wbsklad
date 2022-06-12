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
            $table->string('user_uid');
            $table->date('start_date');
            $table->date('end_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('realization_reports');
    }
}

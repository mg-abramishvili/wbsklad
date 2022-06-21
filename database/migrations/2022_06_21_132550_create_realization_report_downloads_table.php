<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealizationReportDownloadsTable extends Migration
{
    public function up()
    {
        Schema::create('realization_report_downloads', function (Blueprint $table) {
            $table->id();
            $table->string('user_uid');
            $table->string('key');
            $table->string('start_date');
            $table->string('end_date');
            $table->integer('rrdid');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('realization_report_downloads');
    }
}

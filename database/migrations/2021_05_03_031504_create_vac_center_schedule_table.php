<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacCenterScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vac_center_schedule', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('schedule_id')->unsigned();
            $table->foreign('schedule_id')->references('id')->on('schedule')->onDelete('cascade');
            $table->bigInteger('vac_center_id')->unsigned();
            $table->foreign('vac_center_id')->references('id')->on('vac_center')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vac_center_schedule');
    }
}

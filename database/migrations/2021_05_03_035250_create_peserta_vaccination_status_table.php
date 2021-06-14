<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesertaVaccinationStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peserta_vaccination_status', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('peserta_id')->unsigned();
            $table->foreign('peserta_id')->references('id')->on('peserta')->onDelete('cascade');
            $table->bigInteger('vaccination_status_id')->unsigned();
            $table->foreign('vaccination_status_id')->references('id')->on('vaccination_status')->onDelete('cascade');
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
        Schema::dropIfExists('peserta_vaccination_status');
    }
}

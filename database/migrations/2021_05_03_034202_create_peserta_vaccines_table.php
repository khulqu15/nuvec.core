<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesertaVaccinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peserta_vaccines', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('peserta_id')->unsigned();
            $table->foreign('peserta_id')->references('id')->on('peserta')->onDelete('cascade');
            $table->bigInteger('vaccines_id')->unsigned();
            $table->foreign('vaccines_id')->references('id')->on('vaccines')->onDelete('cascade');
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
        Schema::dropIfExists('peserta_vaccines');
    }
}

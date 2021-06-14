<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesertasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peserta', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nik')->unsigned()->unique();
            $table->string('password');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('api_token');
            $table->date('dob');
            $table->string('address');
            $table->integer('contact');
            $table->integer('age');
            $table->bigInteger('vac_center_id')->unsigned();
            $table->foreign('vac_center_id')->references('id')->on('vac_center')->onDelete('cascade');
            $table->rememberToken();
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
        Schema::dropIfExists('pesertas');
    }
}

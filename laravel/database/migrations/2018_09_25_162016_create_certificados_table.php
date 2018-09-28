<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertificadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificados', function (Blueprint $table) {
            $table->increments('id');
            $table->longtext('html_certificado')->nullable();
            $table->integer('certificados_gerados')->unsigned()->default(0); // conta os certificados gerados.
            $table->integer('status')->unsigned()->default(0);
                // 0 - certificados não foram gerados.
                // 1 - gerando certificados.
                // 2 - todos certificados foram gerados.
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
        Schema::dropIfExists('certificados');
    }
}

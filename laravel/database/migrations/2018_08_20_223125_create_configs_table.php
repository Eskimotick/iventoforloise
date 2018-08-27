<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome_evento');
            $table->integer('status');
                // 0 - evento aberto;
                // 1 - evento ainda não abriu
                // 2 - evento trancado pelo admin
                // 3 - inscriçoes fechadas
            $table->string('inicio_inscricoes');
            $table->string('fim_inscricoes');
            $table->string('fim_pagamentos');
            $table->string('inicio_evento');
            $table->string('fim_evento');          
            $table->string('background_img_path')->nullable();
            $table->string('logo_img_path')->nullable();
            $table->string('favicon_img_path')->nullable();
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
        Schema::dropIfExists('configs');
    }
}

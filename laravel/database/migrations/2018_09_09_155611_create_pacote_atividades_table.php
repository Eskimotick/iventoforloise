<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacoteAtividadesTable extends Migration
{
  public function up()
  {
     Schema::create('pacote_atividades', function (Blueprint $table) {
       $table->increments('id');
       $table->integer('pacote_id')->unsigned()->nullable();
       $table->integer('atividade_id')->unsigned()->nullable();
       $table->timestamps();
     });

     Schema::table('pacote_atividades', function (BluePrint $table) {
        $table->foreign('pacote_id')->references('id')->on('pacotes')->onDelete('set null');
        $table->foreign('atividade_id')->references('id')->on('atividades')->onDelete('set null');
     });
  }

  public function down()
  {
     Schema::dropIfExists('pacote_atividade');
   }
}

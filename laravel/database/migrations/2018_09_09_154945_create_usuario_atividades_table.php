<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioAtividadesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
   public function up()
   {
     Schema::create('usuario_atividades', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('usuario_id')->unsigned()->nullable();
         $table->integer('atividade_id')->unsigned()->nullable();
         $table->string('status')->default('ok');
         $table->timestamps();
     });

     Schema::table('usuario_atividades', function (BluePrint $table) {
        $table->foreign('usuario_id')->references('id')->on('users')->onDelete('set null');
        $table->foreign('atividade_id')->references('id')->on('atividades')->onDelete('set null');
     });
   }
   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
     Schema::dropIfExists('usuario_atividades');
   }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacotesQuartos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacotes_quartos', function (Blueprint $table) {
            
            $table->integer('pacote_id')->unsigned();
            $table->integer('quarto_id')->unsigned();
            $table->timestamps();

        });

        Schema::table('pacote_atividades', function (BluePrint $table) {
            $table->foreign('pacote_id')
                    ->references('id')->on('pacotes')
                    ->onDelete('cascade');

            $table->foreign('atividade_id')
                    ->references('id')->on('quartos')
                    ->onDelete('cascade');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('pacotes_quartos');
        Schema::enableForeignKeyConstraints();
    }
}

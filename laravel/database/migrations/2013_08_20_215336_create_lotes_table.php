<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lotes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lote')->unsigned();
            $table->integer('pacote_id')->unsigned();
            $table->integer('vagas')->unsigned();
            $table->integer('vagas_ocupadas')->unsigned()->default(0);
            $table->string('descricao')->nullable();
            $table->string('valor')->nullable();
            $table->string('vencimento');
            $table->timestamps();

            $table->foreign('pacote_id')
                    ->references('id')->on('pacotes')
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
        Schema::dropIfExists('lotes');
    }
}

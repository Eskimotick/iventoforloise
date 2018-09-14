<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacotes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('descricao');
            $table->integer('lotes')->unsigned();
            $table->integer('vagas')->unsigned();
            $table->integer('vagas_ocupadas')->unsigned()->default(0);
            $table->integer('status')->default(0); 
                // 0 - pacote aberto
                // 1 - pacote fechado até lote_atual abrir
                // 2 - pacote fechado temporariamente aguardando pagamento de boletos
                // 3 - admin trancou pacote temporariamente
                // 4 - pacote fechado acabaram todas as vagas
            
            $table->integer('lote_atual')->unsigned()->default(1);
            $table->integer('pagamentos_abertos')->unsigned()->default(0); // devedores
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
        Schema::dropIfExists('pacotes');
    }
}

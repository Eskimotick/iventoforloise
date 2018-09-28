<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuartosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quartos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hospedagem_id')->unsigned();
            $table->string('nome');
            $table->string('descricao');
            $table->integer('vagas')->unsigned();
            $table->integer('vagas_ocupadas')->unsigned()->default(0);
            $table->integer('status')->default(0);
            $table->string('img_path')->nullable(); 
            $table->timestamps();

            $table->foreign('hospedagem_id')
                    ->references('id')->on('hospedagems')
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
        Schema::dropIfExists('quartos');
        Schema::enableForeignKeyConstraints();
    }

    
}

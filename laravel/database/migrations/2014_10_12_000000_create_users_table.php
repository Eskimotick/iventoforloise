<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname');
            $table->string('email')->unique();
            $table->string('new_email')->nullable();
            $table->string('cpf')->nullable();
            $table->string('nome_completo')->nullable();
            $table->string('password');
            $table->string('confirmation_code')->nullable();
            $table->string('password_reset_code')->nullable();
            $table->timestamp('email_code_date')->nullable();
            $table->string('new_email_code')->nullable();
            $table->string('old_email_code')->nullable();
            $table->boolean('confirmed')->default(0);
            $table->string('admin')->default('false');
            //table->integer('lote_id')->unsigned()->nullable();
            $table->integer('quarto_id')->unsigned()->nullable();
            //table->integer('google_id')->unsigned()->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('quarto_id')
                    ->references('id')->on('quarto')
                    ->onDelete('set null');
        });

        
        //Schema::table('users', function (BluePrint $table) {
        //    $table->foreign('lote_id')->references('id')->on('lote')->onDelete('set null');
        //    
        //});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

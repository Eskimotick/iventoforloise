<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon as Carbon;

class ConfigsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configs = [
            [
            'status' => 1,
            'inicio_evento' => "2020-11-15 10:00:00",
            'fim_evento' => "2020-12-15 10:00:00",
            'inicio_inscricoes' => "2020-10-16 10:00:00",
            'fim_inscricoes'=> "2020-11-10 10:00:00",
            'fim_pagamentos' => "2020-11-14 10:00:00",
            'nome_evento' => 'iVento 4.0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
            ]
        ];

        DB::table('configs')->insert($configs);
    }
}

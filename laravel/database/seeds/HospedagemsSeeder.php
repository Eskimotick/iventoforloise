<?php

use Illuminate\Database\Seeder;

class HospedagemsSeeder extends Seeder
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
                'nome' => 'Copabacana Palace',
                'descricao'=> 'Hotel Maneiro Em copacabana',
                'localizacao' => 'Praia de Copacabana',
                'vagas' => 1000, 
                'vagas_ocupadas' => 0,
                'status' => 0,
            ]
        ];

        DB::table('hospedagems')->insert($configs);
    }
}

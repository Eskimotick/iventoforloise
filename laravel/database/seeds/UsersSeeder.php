<?php

use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
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
                'nickname' => 'Administrador Carrasco',
                'email' => "admin@admin.com",
                'cpf' => "72007462826",
                'confirmation_code' => \Ramsey\Uuid\Uuid::uuid4(),
                'password' => bcrypt('admin'),
                'confirmed' => 1,
                'admin' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],

            [
                'nickname' => 'Demo Carrasco',
                'email' => "demo@demo.com",
                'cpf' => "15203573891",
                'confirmation_code' => \Ramsey\Uuid\Uuid::uuid4(),
                'password' => bcrypt('demo'),
                'confirmed' => 1,
                'admin' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]

        ];

        DB::table('users')->insert($configs);
    }
}

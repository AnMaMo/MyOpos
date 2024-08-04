<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PreguntaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('preguntas')->insert([
            [
                'enunciado' => '¿Cuál es la capital de Francia?',
                'fallada' => 0,
            ],
            [
                'enunciado' => '¿Cuál es el resultado de 2 + 2?',
                'fallada' => 0,
            ],
            [
                'enunciado' => '¿En qué año llegó el hombre a la luna?',
                'fallada' => 0,
            ],
        ]);
    }
}
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
                'explicacion' => 'Explicacion de francia',
            ],
            [
                'enunciado' => '¿Cuál es el resultado de 2 + 2?',
                'fallada' => 'Explicacion de 2+2',
            ],
            [
                'enunciado' => '¿En qué año llegó el hombre a la luna?',
                'fallada' => 'Explicacion hombre luna',
            ],
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RespuestaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('respuestas')->insert([
            [
                'pregunta_id' => 1,
                'correcta' => 1,
                'respuesta' => 'París',
            ],
            [
                'pregunta_id' => 1,
                'correcta' => 0,
                'respuesta' => 'Londres',
            ],
            [
                'pregunta_id' => 2,
                'correcta' => 1,
                'respuesta' => '4',
            ],
            [
                'pregunta_id' => 2,
                'correcta' => 0,
                'respuesta' => '5',
            ],
            [
                'pregunta_id' => 3,
                'correcta' => 1,
                'respuesta' => '1969',
            ],
            [
                'pregunta_id' => 3,
                'correcta' => 0,
                'respuesta' => '1970',
            ],
        ]);
    }
}

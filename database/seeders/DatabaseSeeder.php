<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@myopos.com',
        ]);

        // Llamar a los seeders de Pregunta y Respuesta
        $this->call([
            PreguntaSeeder::class,
            RespuestaSeeder::class,
        ]);
    }
}

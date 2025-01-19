<?php

// app/Http/Controllers/TestController.php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TestsController extends Controller
{
    /**
     * Funcion principal que carga la vista de Tests, cargara una pregunta aleatoriamente.
     */
    public function index(){
        // Cojemos todas las preguntas de la BBDD que tengan por lo menos una respuesta.
        $preguntas = Pregunta::with('respuestas')->get();
        
        // Cojemos una pregunta aleatoria de todas las preguntas existentes.
        $preguntaAleatorias = $preguntas->shuffle()->take(1);

        // Retornar la vista con los datos
        return Inertia::render('Tests/TestsIndex', [
            'pregunta' => $preguntaAleatorias
        ]);
    }

}

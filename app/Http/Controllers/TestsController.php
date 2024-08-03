<?php

// app/Http/Controllers/TestController.php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TestsController extends Controller
{
    public function index()
    {
        $preguntas = Pregunta::with('respuestas')->get();
        //TODO poner que coja 30 preguntas
        $preguntasAleatorias = $preguntas->shuffle()->take(2);

        // Retornar la vista con los datos
        return Inertia::render('Tests/TestActivo', [
            'preguntas' => $preguntasAleatorias
        ]);
    }
}

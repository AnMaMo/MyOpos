<?php

namespace App\Http\Controllers;
use App\Models\Pregunta;
use Inertia\Inertia;

class PreguntasController extends Controller
{
    public function index()
    {

        // Cojemos todas las preguntas
        $preguntas = Pregunta::all();

        // Retornar la vista Inertia correcta
        return Inertia::render('Preguntas/PreguntasIndex', [
            'preguntas' => $preguntas
        ]);
    }
}

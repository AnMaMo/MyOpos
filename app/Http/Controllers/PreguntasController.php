<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
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

    // Funcion para crear una pregunta y sus respuestas
    public function crearPregunta(Request $request)
    {
        // Validar los datos del request
        $request->validate([
            'enunciado' => 'required|string',
            'explicacion' => 'required|string',
            'respuestas' => 'required|array',
            'respuestas.*.respuesta' => 'required|string',
            'respuestas.*.correcta' => 'required|boolean',
        ]);

        // Extraer los datos del request
        $enunciado = $request->input('enunciado');
        $explicacion = $request->input('explicacion');
        $respuestas = $request->input('respuestas');

        // Crear la pregunta
        $pregunta = Pregunta::create([
            'enunciado' => $enunciado,
            'explicacion' => $explicacion,
        ]);

        // Iterar sobre el array $respuestas y crear cada respuesta
        foreach ($respuestas as $respuestaData) {
            $pregunta->respuestas()->create([
                'respuesta' => $respuestaData['respuesta'],
                'correcta' => $respuestaData['correcta'],
            ]);
        }

        return response()->json(['mensaje' => 'Pregunta y respuestas creadas con éxito'], 201);
    }

    // Funcion para eliminar una pregunta
    public function eliminarPregunta(Request $request){
        // Validar que el ID de la pregunta esté presente
        $request->validate([
            'id' => 'required|integer|exists:preguntas,id',
        ]);

        // Obtener el ID de la pregunta
        $id = $request->input('id');

        // Encontrar y eliminar la pregunta
        $pregunta = Pregunta::findOrFail($id);
        $pregunta->delete();

        return response()->json(['mensaje' => 'Pregunta eliminada con éxito'], 200);
    }


}

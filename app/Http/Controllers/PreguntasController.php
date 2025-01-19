<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Pregunta;
use App\Models\Respuesta;
use Inertia\Inertia;

class PreguntasController extends Controller
{

    public function index()
    {

        //Comprovacion para ver que el usuario tenga permisos
        if (auth()->user()->isAdmin() !== 1) {
            
            return redirect()->route('Tests');
        }

        // Cojemos todas las preguntas
        $preguntas = Pregunta::all();

        // Retornar la vista Inertia correcta
        return Inertia::render('Preguntas/PreguntasIndex', [
            'preguntas' => $preguntas,
            'rol' => auth()->user()->isAdmin(),
        ]);
    }

    // Funcion para añadir una pregunta
    public function AñadirPregunta(Request $request)
    {
        // Validar los datos del request
        $request->validate([
            'enunciado' => 'required|string',
            'explicacion' => 'required|string'
        ]);

        // Extraer los datos de la peticion ajax (las dos variables)
        $enunciado = $request->input('enunciado');
        $explicacion = $request->input('explicacion');
        
        // Crear la pregunta
        $pregunta = Pregunta::create([
            'enunciado' => $enunciado,
            'explicacion' => $explicacion,
        ]);

        // Retornar el JSON con un mensaje y el ID de la pregunta creada
        return response()->json([
            'mensaje' => 'Pregunta creada con éxito',
            'idPregunta' => $pregunta->id,
        ], 201);
    }

    // Funcion para añadir una respuesta y sus respuestas
    public function AñadirRespuesta(Request $request)
    {
        // Validar los datos del request
        $request->validate([
            'respuesta'=> 'required|string',
            'idPregunta' => 'required|integer'
        ]);

        // Extraer los datos de la peticion ajax (las tres variables)
        $respuesta = $request->input('respuesta');
        $correcta = $request->input('correcta');
        $idPregunta = $request->input('idPregunta');
        
        // Coger la pregunta que corresponde a la id
        $pregunta = Pregunta::find($idPregunta);
        
        //Mirar que la pregunta no tenga mas de 4 respuestas
        if ($pregunta->respuestas()->count() >= 4) {
            return response()->json(['mensaje' => 'false'], 201);
        }

        // Crear la respuesta
        $pregunta->respuestas()->create([
            'respuesta' => $respuesta,
            'correcta' => $correcta,
        ]);

        return response()->json(['mensaje' => 'true', 'sasd' => $correcta], 201);
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

    // Funcion para eliminar una respuesta
    public function eliminarRespuesta(Request $request){
        // Validar que el ID de la pregunta esté presente
        $request->validate([
            'idRespuesta' => 'required|integer|exists:respuestas,id',
        ]);

        // Obtener el ID de la pregunta
        $idRespuesta = $request->input('idRespuesta');

        // Obtener la pregunta relacionada a la respuesta
        $respuesta = Respuesta::find($idRespuesta);

        // Encontrar y eliminar la respuesta
        $respuesta->delete();

        return response()->json(['mensaje' => 'Respuesta eliminada con éxito'], 200);
    }

    // Funcion que retorna el array de todas las preguntas
    public function getAllPreguntas(){
        $preguntas = Pregunta::all();
        return response()->json($preguntas);
    }

    // funcion para get una pregunta por su ID
    public function getPreguntaById($id){
        $pregunta = Pregunta::find($id);

        return $pregunta;
    }

    // funcion para get una respuesta por su ID
    public function getRespuestaById($id){
        $respuesta = Respuesta::find($id);

        return $respuesta;
    }

    // Funcion para editar una pregunta
    public function editarPregunta(Request $request){
        // Validar que el ID de la pregunta esté presente
        $request->validate([
            'idPregunta' => 'required|integer|exists:preguntas,id',
            'enunciado' => 'required|string',
            'explicacion' => 'required|string'
        ]);

        // Obtener los datos del request
        $enunciado = $request->input('enunciado');
        $explicacion = $request->input('explicacion');

        // Obtener la pregunta por su ID
        $pregunta = Pregunta::find($request->input('idPregunta'));

        // Editar los datos de la pregunta
        $pregunta->enunciado = $enunciado;
        $pregunta->explicacion = $explicacion;
        $pregunta->save();

        return response()->json(['mensaje' => 'Pregunta editada con éxito'], 200);
    }

    // Funcion para editar una respuesta
    public function editarRespuesta(Request $request){
        // Validar que el ID de la respuesta esté presente
        $request->validate([
            'idRespuesta' => 'required|integer|exists:respuestas,id',
            'respuesta'=> 'required|string',
            'correcta' => 'required|boolean'
        ]);

        // Obtener los datos del request
        $respuesta = $request->input('respuesta');
        $correcta = $request->input('correcta');

        // Obtener la respuesta por su ID
        $respuestaObj = Respuesta::find($request->input('idRespuesta'));

        // Editar los datos de la respuesta
        $respuestaObj->respuesta = $respuesta;
        $respuestaObj->correcta = $correcta;
        $respuestaObj->save();

        return response()->json(['mensaje' => 'Respuesta editada con éxito'], 200);
    }

    /**
     * Function para coger el listado de respuestas de una pregunta
     */
    public function getRespuestasByIdPregunta(Request $request){
        // Obtener el ID de la pregunta
        $idPregunta = $request->input('idPregunta');

        // Filtrar las respuestas relacionadas con la pregunta
        $respuestas = Pregunta::find($idPregunta)->respuestas;

        // Retornar las respuestas
        return response()->json($respuestas);
    }
    

}

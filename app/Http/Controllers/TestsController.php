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

        // Miraremos si el usuario tiene Licencia gratuita
        if (auth()->user()->isPremium() !== 1) {

            // Si fecha de contestacion es null pondremos la fecha actual DD-MM-YYYY
            if(auth()->user()->getContestacionDates() == NULL || auth()->user()->getContestacionDates() == '0000-00-00') {
                auth()->user()->setContestacionDate(now()->format('Y-m-d'));
                auth()->user()->save();
            }

            // Si la fecha de contestacion es anterior a la fecha actual DD-MM-YYYY pondremos la fecha a la actual y las contestadas a 0
            if(auth()->user()->getContestacionDates() < now()->format('Y-m-d')) {
                auth()->user()->setContestacionDate(now()->format('Y-m-d'));
                auth()->user()->resetContestadasPreguntas();
                auth()->user()->save();
            }

            // Si la fecha de contestacion es igual a la fecha actual DD-MM-YYYY y ya ha contestado 5 preguntas pondremos un return false;
            if(auth()->user()->getContestacionDates() == now()->format('Y-m-d') && auth()->user()->getContestadasPreguntas() >= 5) {
                // Retornar la vista con los datos
                return Inertia::render('Error/MejorarLicencia', [
                ]);
            }
        }

        // Cojemos todas las preguntas de la BBDD que tengan por lo menos una respuesta.
        $preguntas = Pregunta::with('respuestas')->get();
        
        // Cojemos una pregunta aleatoria de todas las preguntas existentes.
        $preguntaAleatorias = $preguntas->shuffle()->take(1);

        // Retornar la vista con los datos
        return Inertia::render('Tests/TestsIndex', [
            'pregunta' => $preguntaAleatorias
        ]);
    }

    /**
     * Funcion usada para incrementar el contador en caso de licencia gratuita
     */
    public function incrementarContadorLicencia(){
        // Miraremos si el usuario tiene Licencia gratuita
        if (auth()->user()->isPremium() !== 1) {
            // Incrementamos el contador
            auth()->user()->addContestadaPregunta();
            auth()->user()->save();
        }
    }

}

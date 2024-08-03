<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla si no es la versión pluralizada del nombre del modelo
    protected $table = 'respuestas';

    // Especifica los campos que se pueden asignar en masa
    protected $fillable = [
        'idpregunta', 'respuesta', 'correcta',
    ];

    // Define la relación con el modelo Pregunta
    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class);
    }

}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    use HasFactory;

    // Si el nombre de la tabla no es la versión pluralizada del nombre del modelo,
    // puedes especificar el nombre de la tabla aquí.
    protected $table = 'preguntas';

    // Especifica los campos que se pueden asignar en masa
    protected $fillable = [
        'enunciado', 'fallada',
    ];

    public function respuestas()
{
    return $this->hasMany(Respuesta::class);
}

    // Si usas timestamps en la tabla, Laravel lo maneja automáticamente.
    // Si no usas timestamps, añade:
    // public $timestamps = false;
}
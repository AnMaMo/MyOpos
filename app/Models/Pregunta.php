<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    // Si el nombre de la tabla no es plural en inglés, puedes especificarlo aquí
    protected $table = 'preguntas';

    protected $fillable = ['enunciado', 'explicacion', 'respuestas'];

    /**
     * Set the enunciado attribute.
     *
     * @param  string  $value
     * @return void
     */
    public function setEnunciadoAttribute($value)
    {
        $this->attributes['enunciado'] = ucfirst($value);
    }

    /**
     * Set the fallada attribute.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setFalladaAttribute($value)
    {
        $this->attributes['fallada'] = (int) $value;
    }

    /**
     * Obtener las respuestas asociadas a la pregunta.
     */
    public function respuestas()
    {
        return $this->hasMany(Respuesta::class);
    }
}

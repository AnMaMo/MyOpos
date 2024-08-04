<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    // Si el nombre de la tabla no es plural en inglés, puedes especificarlo aquí
    protected $table = 'respuestas';

    // Si quieres definir campos que se pueden asignar en masa
    protected $fillable = [
        'pregunta_id',
        'correcta',
        'respuesta',
    ];

    /**
     * Set the correcta attribute.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setCorrectaAttribute($value)
    {
        $this->attributes['correcta'] = (int) $value;
    }

    /**
     * Set the respuesta attribute.
     *
     * @param  string  $value
     * @return void
     */
    public function setRespuestaAttribute($value)
    {
        $this->attributes['respuesta'] = ucfirst($value);
    }

    /**
     * Obtener la pregunta asociada a la respuesta.
     */
    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class);
    }
}

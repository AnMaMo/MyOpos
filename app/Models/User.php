<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'licencia',
        'FechaContestacion',
        'PreguntasContestadas'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Funcion para get el rol del usuario
    public function isAdmin()
    {
        return $this->rol;
    }

    // Funcion para get la licencia del usuario
    public function isPremium()
    {
        return $this->licencia;
    }

    // Funcion para get las fechas de contestacion del usuario
    public function getContestacionDates()
    {
        return $this->FechaContestacion;
    }

    // Funcion para set fecha contestacion del usuario DD-MM-YYYY
    public function setContestacionDate($date)
    {
        $this->FechaContestacion = $date;
        $this->save();
    }

    // Funcion para get las preguntas contestadas del usuario
    public function getContestadasPreguntas()
    {
        return $this->PreguntasContestadas;
    }

    // Funcion para añadir una pregunta contestada al usuario
    public function addContestadaPregunta()
    {
        $this->PreguntasContestadas++;
        $this->save();
    }

    // Funcion para resetear las preguntas contestadas al usuario
    public function resetContestadasPreguntas()
    {
        $this->PreguntasContestadas = 0;
        $this->save();
    }
}

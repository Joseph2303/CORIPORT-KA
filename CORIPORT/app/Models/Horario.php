<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Horario extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'horario';
    protected $primaryKey = "idHorario";
    public $timestamps = false;

    protected $fillable = [
        'idHorario',
        'horaInicio',
        'horaFin',
        'fecha',
    ];

    public function marcas()
    {
        return $this->hasMany('App\Models\Marca', 'idHorario', 'idHorario');
    }
    public function horasExtra()
    {
        return $this->hasMany('App\Models\HorasExtra', 'idHorario', 'idHorario');
    }
}

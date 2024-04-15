<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Marca extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'marca';
    protected $primaryKey = "idMarca";
    public $timestamps = false;

    protected $fillable = [
        'idMarca',
        'fecha', 'hora', 'tipo', 'idHorario', 'idEmpleado'
    ];
    public function horario()
    {
        return $this->belongsTo('App\Models\Horario', 'idHorario');
    }
    // En el modelo Marca
    public function empleado()
    {
        return $this->belongsTo('App\Models\Empleado', 'idEmpleado');
    }
}

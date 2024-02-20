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
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'idMarca',
        'horaInicio', 'horaFin', 'fecha', 'idEmpleado'
    ];
    public function empleado()
    {
        return $this->belongsTo('App\Models\Empleado', 'idEmpleado', 'idMarca');
    }
}

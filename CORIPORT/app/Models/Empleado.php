<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Empleado extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'empleado';
    protected $primaryKey = "idEmpleado";
    public $timestamps = false;

    protected $fillable = [
        'idEmpleado',
        'nombre',
        'apellido1',
        'apellido2',
        'telefono1',
        'telefono2',
        'cedula',
        'fechaContrat',
        'idUsuario',
        'idPuesto'
    ];
    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario', 'idUsuario');
    }

    public function puesto()
    {
        return $this->belongsTo('App\Models\Puesto','idPuesto');
    }
    public function horarios()
    {
        return $this->hasMany('App\Models\Horario', 'idEmpleado');
    }
    public function soliVacaciones()
    {
        return $this->hasMany('App\Models\soliVacaciones','idEmpleado');
    }
}

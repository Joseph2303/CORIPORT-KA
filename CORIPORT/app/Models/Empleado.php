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
        return $this->belongsTo('App\Models\Puesto', 'idPuesto');
    }
    public function marcas()
    {
        return $this->hasMany('App\Models\Marca', 'idEmpleado');
    }
    public function soliVacaciones()
    {
        return $this->hasMany('App\Models\solicitudVacaciones', 'idEmpleado');
    }
    public function registroAusencia()
    {
        return $this->hasMany('App\Models\RegistroAusencia', 'idEmpleado', 'idEmpleado');
    }
    public function registroTardia()
    {
        return $this->hasMany('App\Models\RegistroTardia', 'idEmpleado', 'idEmpleado');
    }

    public function vacaciones()
    {
        return $this->hasMany('App\Models\Vacaciones', 'idEmpleado', 'idEmpleado');
    }
    public function horariosEmpleados()
    {
        return $this->hasOne('App\Models\HorariosEmpleados', 'Empleado', 'idEmpleado');
    }
    public function faceId()
    {
        return $this->hasOne('App\Models\FaceId', 'idEmpleado', 'idEmpleado');
    }
}

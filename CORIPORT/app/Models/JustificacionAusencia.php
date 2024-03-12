<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class JustificacionAusencia extends Model
{

    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'justificacionAusencia';
    protected $primaryKey = 'idJustificacionAusencia'; 
    public $timestamps = false; 

    protected $fillable = [
        'fechaSolicitud',
        'fechaAusencia',
        'archivos',
        'justificacion',
        'estado',
        'descripcion',
        'NombreEncargado',
        'idEmpleado',
    ];
    
    public function empleado()
    {
        return $this->belongsTo('App\Models\Empleado', 'idEmpleado');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class solicitudVacaciones extends Model
{
    use HasFactory;
    protected $table = 'solicitudVacaciones';

    protected $primaryKey = "idSoliVacaciones";

    public $timestamps = false;

    protected $fillable = [
        'idSoliVacaciones',
        'fechSolicitud',
        'fechInicio',
        'fechFin',
        'estado',
        'responsableAut',
        'descripcion',
        'idEmpleado'
    ];
    public function empleado()
    {
        return $this->belongsTo('App\Models\Empleado', 'idEmpleado');
    }
}

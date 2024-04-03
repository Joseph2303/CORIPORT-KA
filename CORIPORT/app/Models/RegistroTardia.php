<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class RegistroTardia extends Model
{

    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'registroTardia';
    protected $primaryKey = 'idResgistroTardia'; 
    public $timestamps = false; 

    protected $fillable = [
        'idResgistroTardia',
        'fecha',
        'hora',
        'idJustificacionTardia',
        'idEmpleado'
    ];
    
    public function empleado()
    {
        return $this->belongsTo('App\Models\Empleado', 'idEmpleado', 'idEmpleado');
    }
    
    public function justificacionTardia()
    {
        return $this->belongsTo('App\Models\JustificacionTardia', 'idJustificacionTardia', 'idJustificacionTardia');
    }
    
}

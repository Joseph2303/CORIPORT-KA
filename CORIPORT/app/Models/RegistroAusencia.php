<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class RegistroAusencia extends Model
{

    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'registroAusencia';
    protected $primaryKey = 'idResgistroAusencia'; 
    public $timestamps = false; 

    protected $fillable = [
        'idResgistroAusencia',
        'fecha',
        'hora',
        'idJustificacionAusencia',
        'idEmpleado'
    ];
    
    public function empleado()
    {
        return $this->belongsTo('App\Models\Empleado', 'idEmpleado', 'idEmpleado');
    }
    
    public function justificacionAusencia()
    {
        return $this->belongsTo('App\Models\JustificacionAusencia', 'idJustificacionAusencia', 'idJustificacionAusencia');
    }
    
}

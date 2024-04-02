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
        'archivo',
        'justificacion',
        'estado',
        'descripcion',
        'encargado',
    ];
    
    public function registroAusencia()
    {
        return $this->hasOne('App\Models\RegistroAusencia', 'idJustificacionAusencia', 'idJustificacionAusencia');
    }
}

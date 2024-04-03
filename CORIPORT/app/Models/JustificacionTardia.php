<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class JustificacionTardia extends Model
{

    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'justificacionTardia';
    protected $primaryKey = 'idJustificacionTardia'; 
    public $timestamps = false; 

    protected $fillable = [
        'fechaTardia',
        'archivo',
        'justificacion',
        'estado',
        'encargado',
        'descripcion',
        'fechaSolicitud',
    ];
    
    public function registroTardia()
    {
        return $this->hasOne('App\Models\RegistroTardia', 'idJustificacionTardia', 'idJustificacionTardia');
    }
}

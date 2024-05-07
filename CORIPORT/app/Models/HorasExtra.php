<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class HorasExtra extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table='horasExtra';
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'id',
        'maxHora',
        'cantidadHora',
        'idHorario'
      
    ];
    public function horario(){
        return $this->hasMany('App\Models\Horario','idHorario');
    }
}

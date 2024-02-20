<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Marca extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'marca';
    protected $primaryKey = "idMarca";
    public $timestamps = false;

    protected $fillable = [
        'id',
        'fechaHora', 'tipo', 'idHorario'
    ];
    public function horario()
    {
        return $this->belongsTo('App\Models\Horario', 'idHorario', 'idMarca');
    }
}

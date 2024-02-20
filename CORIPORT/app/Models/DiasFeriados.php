<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class DiasFeriados extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table='diasferiados';
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'id',
        'fecha',
        'descripcion',
        'tipoFeriado'
    ];
    
}

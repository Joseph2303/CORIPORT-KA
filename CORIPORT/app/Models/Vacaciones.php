<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Vacaciones extends Model 
{

    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'vacaciones';
    protected $primaryKey = 'idVacaciones';
    public $timestamps = false;

    protected $fillable = [
        'idVacaciones',
        'periodo',
        'disponibles',
        'diasAsig',
        'idEmpleado'
    ];

    public function empleado(){
        return $this->belongsTo('App\Models\Empleado','idEmpleado');
    }

}
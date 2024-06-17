<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class HorariosEmpleados extends Model{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'HorariosEmpleados';
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'id',
        'Empleado',
        'HoraEntrada',
        'HoraSalida',
        'DiaLibre',
    ];

    public function empleado()
    {
        return $this->belongsTo('App\Models\Empleado', 'Empleado', 'idEmpleado');
    }

}
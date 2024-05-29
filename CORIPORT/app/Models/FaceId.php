<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class FaceId extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'FaceId';
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'id',
        'imageData', 'descriptor', 'idEmpleado'
    ];
    public function empleado()
    {
        return $this->belongsTo('App\Models\Empleado', 'idEmpleado');
    }
}

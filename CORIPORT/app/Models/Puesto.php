<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    use HasFactory;
    protected $table = 'puesto';

    protected $primaryKey = "idPuesto";

    public $timestamps = false;

    protected $fillable = [
        'idPuesto',
        'puesto'
    ];
    public function empleado()
    {
        return $this->belongsTo('App\Models\Empleado', 'idPuesto');
    }
}

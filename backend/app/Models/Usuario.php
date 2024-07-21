<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuario';

    protected $fillable = [
        'Usuario',
        'Clave',
        'Estado',
        'FechaIn',
        'FechaUp',
        'persona_id',
    ];

    public function persona() {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
}

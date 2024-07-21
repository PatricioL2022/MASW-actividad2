<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    protected $table = 'persona';
    protected $fillable = [
        'Identificacion',
        'Nombres',
        'Apellidos',
        'TipoIdentificacion',
        'Genero',
        'Direccion',
        'Telefono',
        'Correo',
        'Titulo',
        'FechaNacimiento',
        'Foto',
        'GrupoSanguineo',
        'Estado',
    ];
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultorio extends Model
{
    use HasFactory;
    
    protected $table = 'consultorio';
    protected $fillable = [
        'Nombre',
        'Ruc',
        'NombreComercial',
        'Direccion',
        'Telefono',
        'PorcentajeIva',
        'Logo',
        'Correo',
        'DireccionMatriz',
        'Estado',
    ];
}

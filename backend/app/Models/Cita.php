<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;
    protected $table = 'cita';
    protected $fillable = [
        'Fecha',
        'agendadetalle_id',
        'Tipo',
        'Estado',
        'Descripcion',
        'paciente_id'
    ];
}

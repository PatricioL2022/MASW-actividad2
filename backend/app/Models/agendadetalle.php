<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agendadetalle extends Model
{
    use HasFactory;
    protected $table = 'agendadetalle';
    protected $fillable = [
        'AgendaId',
        'HoraInicio',
        'HoraFin',
        'Estado'
    ];
}

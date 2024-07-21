<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;
    protected $table = 'medico';
    protected $fillable = [
        'Especialidad',
        'Subespecialidad',
        'NumeroCarnet',
        'persona_id',
        'consultorio_id',
        'Estado',
    ];
    public function persona() {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Horarioatencion extends Model
{
    use HasFactory;

    protected $table = 'horarioatencion';
    //protected $primaryKey = 'IdHorarioatencion';
    protected $fillable = [
        'Nombre',
        'HoraInicio',
        'HoraFin',
        'HoraInicioReceso',
        'HoraFinReceso'
    ];

    public function detalles(): HasMany
    {
        return $this->hasMany(Horarioatenciondetalle::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Horarioatenciondetalle extends Model
{
    use HasFactory;

    protected $table = 'horarioatenciondetalle';
   // protected $primaryKey = 'IdHorarioatenciondetalle';
    protected $fillable = [
        'medico_id',
        'horarioatencion_id'
    ];

    public function horario(): BelongsTo
    {
        return $this->belongsTo(Horarioatencion::class);
    }
    public function medico() {
        return $this->belongsTo(Medico::class, 'medico_id');
    }
}

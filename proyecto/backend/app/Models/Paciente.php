<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;
    protected $table = 'paciente';
    protected $fillable = [
        'NumeroExpediente',
        'Estado',
        'persona_id',
    ];
    public function persona() {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
}

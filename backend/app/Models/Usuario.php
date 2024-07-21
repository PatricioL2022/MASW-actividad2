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
        'Password',
        'rol_id',
        'persona_id',
        'Estado',
    ];
    public function rol() {
        return $this->belongsTo(Rol::class, 'rol_id');
    }
    public function persona() {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
}

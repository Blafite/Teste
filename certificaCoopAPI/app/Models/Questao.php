<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questao extends Model
{
    use HasFactory;

    protected $table = 'questoes';

    protected $fillable = [
        'materia_id',
        'dificuldade',
        'texto_questao',
    ];

    public function materias()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function opcoes(){
        return $this->hasMany(Opcao::class, 'questao_id');
    }
}
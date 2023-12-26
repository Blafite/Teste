<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prova extends Model
{
    use HasFactory;

    protected $table = 'provas';

    protected $fillable = [
        'admin_id',
        'materia_id',
        'codigo',
        'nome_prova',
        'total_questoes',
        'questoes_facil',
        'questoes_intermediaria',
        'questoes_dificil',
        'percentual_aprovacao',
    ];

    public function admin()
    {
        return $this->belongsTo('App\Models\Usuario');
    }

    public function materias()
    {
        return $this->hasMany('App\Models\Materia');
    }
}
    


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoProvaMateria extends Model
{
    use HasFactory;

    protected $table = 'historico_prova_materia';

    protected $fillable = [
        'historico_prova_id',
        'materia_id',
        'nota'
    ];

    public function materia()
    {
        return $this->belongsTo('App\Models\Materia');
    }

    public function prova()
    {
        return $this->belongsTo('App\Models\HistoricoProva');
    }
}

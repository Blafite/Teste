<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoProva extends Model
{
    use HasFactory;

    protected $table = 'historico_prova';

    protected $fillable = [
        'usuario_id',
        'prova_codigo',
        'nota'
    ];

    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario');
    }

    public function prova()
    {
        return $this->belongsTo('App\Models\Prova');
    }
}

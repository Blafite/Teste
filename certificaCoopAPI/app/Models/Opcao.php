<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opcao extends Model
{
    use HasFactory;

    protected $table = 'opcoes';

    protected $fillable = [
        'questao_id',
        'texto_opcao',
        'opcao_correta'
    ];

    public function questao()
    {
        return $this->belongsTo('App\Models\Questao');
    }
    
}

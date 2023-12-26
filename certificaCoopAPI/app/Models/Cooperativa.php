<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cooperativa extends Model
{
    use HasFactory;

    protected $table = 'cooperativas';

    protected $fillable = [
        'nome',
        'cnpj',
        'telefone',
        'descricao',
        'email',
        'endereco',
        'cidade',
        'estado',
        'cep'
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'cooperativa_id');
    }
    
}

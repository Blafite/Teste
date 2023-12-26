<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nome',
        'cpf',
        'sobrenome',
        'email',
        'senha',
        'data_nascimento',
        'genero',
        'telefone',
        'endereco',
        'cidade',
        'estado',
        'cep',
        'profissao',
        'prova_liberada',
        'token',
        'cooperativa_id'
    ];

    public function cooperativa()
    {
        return $this->belongsTo(Cooperativa::class, 'cooperativa_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'senha',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'senha' => 'hashed',
    ];    
}

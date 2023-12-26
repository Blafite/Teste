<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'usuario_id',
        'valor_total',
        'codigo_transacao'
    ];

    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario');
    }
}

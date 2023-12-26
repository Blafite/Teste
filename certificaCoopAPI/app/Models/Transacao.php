<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
    use HasFactory;

    protected $table = 'transacoes';

    protected $fillable = [
        'pedido_id',
        'codigo_transacao',
        'status'
    ];

    public function pedido()
    {
        return $this->belongsTo('App\Models\Pedido');
    }
}

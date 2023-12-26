<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoPagamento extends Model
{
    use HasFactory;

    protected $table = 'historico_pagamento';

    protected $fillable = [
        'transacao_id',
        'valor_pago'
    ];

    public function transacao()
    {
        return $this->belongsTo('App\Models\Transacao');
    }
}

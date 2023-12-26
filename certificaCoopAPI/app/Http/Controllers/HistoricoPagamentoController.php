<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoricoPagamento;

class HistoricoPagamentoController extends Controller
{
    //
    public function criarRegistroHistorico($transacao_id, $valor_pago)
    {
        try {
            $historico = new HistoricoPagamento;
            $historico->transacao_id = $transacao_id;
            $historico->valor_pago = $valor_pago;
            $historico->save();
            
            return response()->json(['message' => 'Registro de pagamento criado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar o registro de pagamento: ' . $e->getMessage()], 500);
        }
    }
    
}

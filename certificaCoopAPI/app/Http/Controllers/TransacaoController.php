<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Transacao;
use App\Http\Controllers\PedidoController;


class TransacaoController extends Controller
{
    public function criarPedidoPagarCartao(Request $request)
    {
        $url = 'https://sandbox.api.pagseguro.com/orders'; // Replace with the actual URL
        
        // Call the cadastrarPedido method from PedidoController
        $pedidoController = new PedidoController();
        $pedidoId = $pedidoController->cadastrarPedido($request->customer['tax_id'], $request->items[0]['unit_amount'], $request->reference_id);
        
        $this->cadastrarTransacao($pedidoId, $request->reference_id);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer 3183C8909CAB454C8F7A253AE84D6257',
                'accept' => 'application/json'
            ])->post($url, $request);
            
            // Check if the request was successful
            if ($response->successful()) {
                // Obtenha a mensagem de retorno da API externa
                $message = $response->json();

                // Chamar a função atualizarStatusTransacao
                $this->atualizarStatusTransacao($pedidoId);

                // Retorne uma resposta JSON com a mensagem de sucesso
                return response()->json(['message' => $message], 200);
                
                // Retorne uma resposta JSON com a mensagem de sucesso
                return response()->json(['message' => $message], 200);
            } else {
                // Obtenha a mensagem de erro da API externa
                $error = $response->json();
        
                // Retorne uma resposta JSON com a mensagem de erro
                return response()->json(['message' => $error], 500);
            }
        } catch (\Exception $e) {
            // Return a JSON response with the error message
            return response()->json(['message' => $e], 500);
        }
    }

    public function cadastrarTransacao($pedido, $codigoTransacao)
    {
        try {
            $transacao = new Transacao;

            $transacao->pedido_id = $pedido;
            $transacao->codigo_transacao = $codigoTransacao;
            $transacao->status = 'OPEN';

            $transacao->save();

            return response()->json(['message' => 'Transação cadastrada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao cadastrar a transação: ' . $e->getMessage()], 400);
        }
    }

    public function atualizarStatusTransacao($pedido_id){
        try {
            $transacao = Transacao::where('pedido_id', $pedido_id)->first();
            
            if ($transacao) {
                $transacao->status = 'PAID';
                $transacao->save();

                // Chamar a função criarRegistroHistorico da HistoricoPagamentoController
                $historicoPagamentoController = new HistoricoPagamentoController();
                $historicoPagamentoController->criarRegistroHistorico($transacao->id, $transacao->valor_pago);
                
                $usuarioController = new UsuarioController();
                $pedidoController = new PedidoController();
                $pedido = $pedidoController->buscarPedidoPorId($pedido_id);
                $usuario_id = $pedido->usuario_id;
                $usuarioController->atualizarProvaLiberada($usuario_id, true);              

                return response()->json(['message' => 'Status da transação atualizado para PAID'], 200);
                
                
                return response()->json(['message' => 'Status da transação atualizado para PAID'], 200);
            } else {
                return response()->json(['message' => 'Transação não encontrada'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar o status da transação: ' . $e->getMessage()], 500);
        }
    }
    
    public function listarTransacoesPorUsuario(Request $request, $codigoUsuario)
    {
        try {
            $transacoes = Transacao::with('pedido')->whereHas('pedido', function ($query) use ($codigoUsuario) {
                $query->where('usuario_id', $codigoUsuario);
            })->orderBy('created_at', 'desc')->get();

            return response()->json($transacoes, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao listar as transações: ' . $e->getMessage()], 500);
        }
    }
}

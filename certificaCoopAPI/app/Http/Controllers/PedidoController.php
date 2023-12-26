<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Usuario;
use App\Http\Controllers\TransacaoController;

class PedidoController extends Controller
{
    //
    public function cadastrarPedido($cpf, $valor, $codigoTransacao)
    {
        try {
            $cpfMascara = $this->mascara($cpf, '###.###.###-##');
            $usuario_id = Usuario::where('cpf', $cpfMascara)->first()->id;
            
            $pedido = new Pedido;

            $pedido->usuario_id = $usuario_id;
            $pedido->valor_total = $valor/100;
            $pedido->codigo_transacao = $codigoTransacao;

            $pedido->save();

            return $pedido->id;
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao cadastrar o pedido: ' . $e->getMessage()], 400);
        }
    }

    public function buscarPedidoPorId($pedido_id)
    {
        try {
            $pedido = Pedido::findOrFail($pedido_id);
            return $pedido;
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao buscar o pedido: ' . $e->getMessage()], 400);
        }
    }
    

    public function mascara($valor, $formato) {
        $retorno = '';
        $posicao_valor = 0;
        for($i = 0; $i<=strlen($formato)-1; $i++) {
            if($formato[$i] == '#') {
                if(isset($valor[$posicao_valor])) {
     $retorno .= $valor[$posicao_valor++];
     }
            } else {
                $retorno .= $formato[$i];
            }
        }
        return $retorno;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoricoProva;
use App\Http\Controllers\ProvaController;
use App\Http\Controllers\UsuarioController;

class HistoricoProvaController extends Controller
{
    //
    public function cadastrarHistoricoProva(Request $request)
    {
        try {
            $historicoProva = new HistoricoProva();        
            $historicoProva->fill($request->all());
            // Preencha os outros campos do usuário

            // Preencha os outros campos do usuário

            // Chamar o método atualizarProvaLiberada do usuarioController passando o valor false
            $usuarioController = new UsuarioController();
            $usuarioController->atualizarProvaLiberada($historicoProva->usuario_id, false);

            // Chamar a função dadosProva de ProvaController passando o codigo da prova
            $provaController = new ProvaController();
            $prova = $provaController->dadosProva($historicoProva->prova_codigo);

            if ($historicoProva->nota > $prova->percentual_aprovacao) {
                $usuarioController->atualizarCarreira($historicoProva->usuario_id, $historicoProva->prova_codigo);
            }
            
            
            $historicoProva->save();

            return response()->json(['message' => $historicoProva->id]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao cadastrar o histórico: ' . $e->getMessage()], 400);
        }
    }

    public function listarProvasUsuario(Request $request, $id){
        try{
            $historicoProva = HistoricoProva::where('usuario_id', $id)->orderBy('created_at', 'desc')->get();

            $provaController = new ProvaController();
            foreach ($historicoProva as $prova) {
                $prova->prova = $provaController->dadosProva($prova->prova_codigo);
            }
            
            return $historicoProva;
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao cadastrar o histórico: ' . $e->getMessage()], 400);
        }
        
    }
    
    public function dadosProvaEspecifica(Request $request, $codigo){
        try{
            $prova = HistoricoProva::with('prova')->where('id', $codigo)->first();
            return $prova;
        }
        catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao buscar a prova: ' . $e->getMessage()], 400);
        }
    }
    
}

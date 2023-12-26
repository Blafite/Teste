<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opcao;

class OpcaoController extends Controller
{
    
    //
    public function listarTodos()
    {
        try {
            $opcoes = Opcao::all();

            return response()->json($opcoes);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao listar as opções: ' . $e->getMessage()], 400);
        }
    }
    
    public function cadastrar(Request $request)
    {
        try {
            $opcoes = Opcao::where('questao_id', $request->questao_id)->get();
            if(count($opcoes) >= 5){
                return response()->json(['message' => 'Erro ao cadastrar a opção: Uma questão só pode ter 5 opções'], 400);
            }
            if($request->opcao_correta == true){
                $opcao_correta = Opcao::where('questao_id', $request->questao_id)->where('opcao_correta', true)->first();
                if($opcao_correta){
                    $opcao_correta->opcao_correta = false;
                    $opcao_correta->save();
                }
            }
            $opcao = new Opcao();
            $opcao->questao_id = $request->questao_id;
            $opcao->texto_opcao = $request->texto_opcao;
            $opcao->opcao_correta = $request->opcao_correta;
            
            $opcao->save();

            return response()->json(['message' => 'Opção cadastrada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao cadastrar a opção: ' . $e->getMessage()], 400);
        }
    }

    public function atualizar(Request $request, $id)
    {
        try {
            $opcao = Opcao::findOrFail($id);
            if($request->opcao_correta == true){
                $opcao_correta = Opcao::where('questao_id', $opcao->questao_id)->where('opcao_correta', true)->first();
                if($opcao_correta && $opcao_correta->id != $id){
                    $opcao_correta->opcao_correta = false;
                    $opcao_correta->save();
                }
            }
            $opcao->questao_id = $request->questao_id;
            $opcao->texto_opcao = $request->texto_opcao;
            $opcao->opcao_correta = $request->opcao_correta;
            $opcao->save();

            return response()->json(['message' => 'Opção atualizada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar a opção: ' . $e->getMessage()], 400);
        }
    }

    public function deletar($id)
    {
        try {
            $opcao = Opcao::findOrFail($id);
            $opcao->delete();

            return response()->json(['message' => 'Opção deletada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao deletar a opção: ' . $e->getMessage()], 400);
        }
    }
    
}

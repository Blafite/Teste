<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questao;
use App\Models\Opcao;

class QuestaoController extends Controller
{
    //
    public function listarTodos()
    {
        try {
            $questoes = Questao::with('opcoes')->get();

            return response()->json($questoes);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao listar as questões: ' . $e->getMessage()], 400);
        }
    }
    
    public function cadastrarQuestao(Request $request)
    {
        $request->validate([
            'materia_id' => 'required',
            'dificuldade' => 'required',
            'texto_questao' => 'required',
        ]);

        try {
            $questao = new Questao;

            $questao->fill($request->all());

            $questao->save();

            return response()->json(['message' => 'Questão cadastrada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao cadastrar a questão: ' . $e->getMessage()], 400);
        }
    }
    
    public function atualizarQuestao(Request $request, $id)
    {
        $request->validate([
            'prova_id' => 'required',
            'dificuldade' => 'required',
            'texto_questao' => 'required',
        ]);

        try {
            $questao = Questao::findOrFail($id);

            $questao->prova_id = $request->prova_id;
            $questao->dificuldade = $request->dificuldade;
            $questao->texto_questao = $request->texto_questao;

            $questao->save();

            return response()->json(['message' => 'Questão atualizada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar a questão: ' . $e->getMessage()], 400);
        }
    }
    
    public function deletarQuestao($id)
    {
        try {
            $questao = Questao::findOrFail($id);

            // Deletar as opções relacionadas à questão
            Opcao::where('questao_id', $id)->delete();

            // Deletar a questão
            $questao->delete();

            return response()->json(['message' => 'Questão deletada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao deletar a questão: ' . $e->getMessage()], 400);
        }
    }
    
}

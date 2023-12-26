<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prova;
use App\Models\Questao;
use App\Models\Opcao;

class ProvaController extends Controller
{
    //
    public function cadastrar(Request $request)
    {
        try {
            $prova = new Prova();
            $prova->fill($request->all());
            $prova->save();

            return response()->json(['message' => 'Prova cadastrada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao cadastrar a prova: ' . $e->getMessage()], 400);
        }
    }

    public function atualizar(Request $request, $id)
    {
        try {
            $prova = Prova::findOrFail($id);
            $prova->admin_id = $request->admin_id;
            $prova->nome_prova = $request->nome_prova;
            $prova->total_questoes = $request->total_questoes;
            $prova->questoes_facil = $request->questoes_facil;
            $prova->questoes_intermediaria = $request->questoes_intermediaria;
            $prova->questoes_dificil = $request->questoes_dificil;
            $prova->percentual_aprovacao = $request->percentual_aprovacao;
            $prova->save();

            return response()->json(['message' => 'Prova atualizada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar a prova: ' . $e->getMessage()], 400);
        }
    }

    public function deletar($id)
    {
        try {
            $prova = Prova::findOrFail($id);
            
            // Obter todas as questões relacionadas à prova
            $questoes = Questao::where('prova_id', $id)->get();

            // Instanciar o QuestaoController
            $questaoController = new QuestaoController();

            // Deletar todas as questões relacionadas à prova
            foreach ($questoes as $questao) {
                $questaoController->deletarQuestao($questao->id);
            }

            // Deletar a prova
            $prova->delete();

            return response()->json(['message' => 'Prova e suas questões relacionadas foram deletadas com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao deletar a prova e suas questões relacionadas: ' . $e->getMessage()], 400);
        }
    }
    
    public function gerarProva($id)
    {
        try {
            $prova = Prova::where('codigo', $id)->get();
            
            // Obter questões fáceis, intermediárias e difíceis
            $questoes = [];
            foreach ($prova as $p) {
                $questao = Questao::with('opcoes')->where('materia_id', $p->materia_id)->where('dificuldade', '1')->take($p->questoes_facil)->inRandomOrder()->get();
                $questoes[] = $questao->first();
            }

            return response()->json([
                'message' => 'Prova gerada com sucesso!',
                'questoes' => $questoes
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao gerar a prova: ' . $e->getMessage()], 400);
        }
    }

    public function retornarProvas()
    {
        try {
            $provas = Prova::select('codigo', 'nome_prova', 'valor', 'percentual_aprovacao')->distinct()->get();
            
            return response()->json([
                'provas' => $provas
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao retornar as provas: ' . $e->getMessage()], 400);
        }
    }

        public function dadosProva($codigo) {
            try {
                // Seu código de tratativa de erro aqui
                $prova = Prova::where('codigo', $codigo)->first();

                return $prova;
            } catch (\Exception $e) {
                return response()->json(['message' => 'Erro ao obter os dados da prova: ' . $e->getMessage()], 400);
            }
        
    }
    
    
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cooperativa;

class CooperativaController extends Controller
{
    //
    public function listarTodos()
    {
        try {
            $cooperativas = Cooperativa::all();
            return response()->json($cooperativas);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao listar as cooperativas: ' . $e->getMessage()], 400);
        }
    }

    public function cadastrar(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'endereco' => 'required',
            // Adicione aqui outras validações de campos conforme necessário
        ]);

        try {
            $cooperativa = new Cooperativa();
            $cooperativa->fill($request->all());
            $cooperativa->save();
            return response()->json(['message' => 'Cooperativa criada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar a cooperativa: ' . $e->getMessage()], 400);
        }
    }

    public function mostrar($id)
    {
        try {
            $cooperativa = Cooperativa::findOrFail($id);
            return response()->json($cooperativa);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao mostrar a cooperativa: ' . $e->getMessage()], 400);
        }
    }

    public function atualizar(Request $request, $id)
    {
        try {
            $cooperativa = Cooperativa::findOrFail($id);
            $cooperativa->fill($request->all());
            $cooperativa->save();
            return response()->json(['message' => 'Cooperativa atualizada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar a cooperativa: ' . $e->getMessage()], 400);
        }
    }

    public function deletar($id)
    {
        try {
            $cooperativa = Cooperativa::findOrFail($id);
            $cooperativa->delete();
            return response()->json(['message' => 'Cooperativa deletada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao deletar a cooperativa: ' . $e->getMessage()], 400);
        }
    }
    
}

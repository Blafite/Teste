<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoricoProvaMateria;

class HistoricoProvaMateriaController extends Controller
{
    //
    public function cadastrarHistoricoMateria(Request $request)
    {
        try {
            $historicoProvaMateria = new HistoricoProvaMateria();        
            $historicoProvaMateria->fill($request->all());
            // Preencha os outros campos do usuário

            $historicoProvaMateria->save();

            return response()->json(['message' => 'Histórico Prova cadastrado com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao cadastrar o histórico: ' . $e->getMessage()], 400);
        }
    }

    public function detalharProva(Request $request, $id)
    {
        try {
            $registros = HistoricoProvaMateria::with('materia')->where('historico_prova_id', $id)->get();
            return response()->json($registros);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao buscar os registros: ' . $e->getMessage()], 400);
        }
    }

    
}

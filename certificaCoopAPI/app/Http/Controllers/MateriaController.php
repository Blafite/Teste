<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materia;

class MateriaController extends Controller
{
    //
    public function listarTodos()
    {
        try {
            $materias = Materia::all();
            return response()->json($materias);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao listar as materias: ' . $e->getMessage()], 400);
        }
    }

    public function cadastrar(Request $request)
    {
        try {
            $materia = new Materia();
            $materia->fill($request->all());
            $materia->save();
            return response()->json(['message' => 'Materia criada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar a materia: ' . $e->getMessage()], 400);
        }
    }

    public function mostrar($id)
    {
        try {
            $materia = Materia::findOrFail($id);
            return response()->json($materia);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao mostrar a materia: ' . $e->getMessage()], 400);
        }
    }

    public function atualizar(Request $request, $id)
    {
        try {
            $materia = Materia::findOrFail($id);
            $materia->fill($request->all());
            $materia->save();
            return response()->json(['message' => 'materia atualizada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar a materia: ' . $e->getMessage()], 400);
        }
    }

    public function deletar($id)
    {
        try {
            $materia = Materia::findOrFail($id);
            $materia->delete();
            return response()->json(['message' => 'materia deletada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao deletar a materia: ' . $e->getMessage()], 400);
        }
    }
    
}

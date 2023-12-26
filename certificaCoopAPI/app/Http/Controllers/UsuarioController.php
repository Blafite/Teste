<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UsuarioController extends Controller
{
    public function cadastrar(Request $request)
    {
        try {
            // Validação dos dados do formulário
            $request->validate([
                'nome' => 'required',
                'cpf' => 'required',
                'email' => 'required',
                'senha' => 'required',
                'telefone' => 'required',
                'cooperativa_id' => 'required'            
                // Adicione outras regras de validação conforme necessário
            ]);

            // Criar um novo usuário
            $usuario = new Usuario();        
            $usuario->fill($request->all());
            // Preencha os outros campos do usuário

            $usuario->save();

            return response()->json(['message' => 'Usuário cadastrado com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao cadastrar o usuário: ' . $e->getMessage()], 400);
        }
    }

    public function atualizar(Request $request, $id)
    {
        try {
            // Encontrar o usuário pelo ID
            $usuario = Usuario::findOrFail($id);

            // Atualizar os dados do usuário se eles forem fornecidos
            $usuario->nome = $request->nome ?? $usuario->nome;
            $usuario->sobrenome = $request->sobrenome ?? $usuario->sobrenome;
            // $usuario->cpf = $request->cpf ?? $usuario->cpf; // CPF não pode ser atualizado
            $usuario->email = $request->email ?? $usuario->email;
            // $usuario->senha = $request->senha ?? $usuario->senha; // Senha não pode ser atualizada
            $usuario->data_nascimento = $request->data_nascimento ?? $usuario->data_nascimento;
            $usuario->telefone = $request->telefone ?? $usuario->telefone;
            $usuario->cooperativa_id = $request->cooperativa_id ?? $usuario->cooperativa_id;
            $usuario->genero = $request->genero ?? $usuario->genero;
            $usuario->endereco = $request->endereco ?? $usuario->endereco;
            $usuario->cidade = $request->cidade ?? $usuario->cidade;
            $usuario->estado = $request->estado ?? $usuario->estado;
            $usuario->cep = $request->cep ?? $usuario->cep;
            $usuario->profissao = $request->profissao ?? $usuario->profissao;

            $usuario->save();

            return response()->json(['message' => 'Usuário atualizado com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar o usuário: ' . $e->getMessage()], 400);
        }
    }
    
    public function atualizarSenha(Request $request, $id)
    {
        try {
            // Encontrar o usuário pelo ID
            $usuario = Usuario::findOrFail($id);

            // A senha é obrigatória para ser fornecida
            if (!$request->has('senha')) {
                return response()->json(['message' => 'A senha é obrigatória'], 400);
            }

            // Atualizar a senha do usuário
            $usuario->senha = bcrypt($request->senha);

            $usuario->save();

            return response()->json(['message' => 'Senha atualizada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar a senha: ' . $e->getMessage()], 400);
        }
    }
    
    public function login(Request $request)
    {
        try {
            // Validação dos dados do formulário
            $request->validate([
                'cpf' => 'required',
                'senha' => 'required',
            ]);

            // Encontrar o usuário pelo CPF
            $usuario = Usuario::with('cooperativa')->where('cpf', $request->cpf)->first();

            // Verificar se o usuário existe e a senha está correta
            if (!$usuario || !Hash::check($request->senha, $usuario->senha)) {
                return response()->json(['message' => 'CPF ou senha inválidos'], 400);
            }

            return response()->json(['message' => 'Login realizado com sucesso!',
                                     'usuario' => $usuario]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao realizar o login: ' . $e->getMessage()], 400);
        }
    }

    public function listarTodos()
    {
        try {
            $usuarios = Usuario::all();
            return response()->json($usuarios);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao listar os usuários: ' . $e->getMessage()], 400);
        }
    }

    public function mostrar(Request $request, $id)
    {
        try {
            $usuario = Usuario::with('cooperativa')->findOrFail($id);
            return response()->json($usuario);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao mostrar o usuário: ' . $e->getMessage()], 400);
        }
    }

    public function atualizarProvaLiberada($usuario_id, $prova_liberada)
    {
        try {
            // Encontrar o usuário pelo ID
            $usuario = Usuario::findOrFail($usuario_id);

            // Atualizar o campo prova_liberada para true
            $usuario->prova_liberada = $prova_liberada;

            $usuario->save();

            return response()->json(['message' => 'Prova liberada atualizada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar a prova liberada: ' . $e->getMessage()], 400);
        }
    }

    public function atualizarCarreira($usuario_id, $codigo_prova)
    {
        try {
            // Encontrar o usuário pelo ID
            $usuario = Usuario::findOrFail($usuario_id);

            // Atualizar o campo prova_liberada para true
            $usuario->profissao = $codigo_prova;

            $usuario->save();

            return response()->json(['message' => 'Usuario atualizado com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar o usuario ' . $e->getMessage()], 400);
        }
    }
    
    public function gerarToken(Request $request, $usuario_email)
    {
        try {
            // Encontrar o usuário pelo email
            $usuario = Usuario::where('email', $usuario_email)->firstOrFail();
            
            // Gerar token aleatório
            $token = rand(100000, 999999);
            
            // Salvar token no campo token
            $usuario->token = $token;
            
            $usuario->save();
            Mail::send(new \App\Mail\EnvioEmails($usuario));
            return response()->json(['message' => 'Token gerado com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao gerar o token: ' . $e->getMessage()], 400);
        }
    }

    public function alterarSenha(Request $request)
    {
        try {
            // Encontrar o usuário pelo CPF
            $usuario = Usuario::where('cpf', $request->cpf)->first();
            
            // Validar token
            if ($request->has('token') && $usuario->token != $request->token) {
                return response()->json(['message' => 'Token inválido'], 400);
            }
            
            // Alterar senha
            $usuario->senha = Hash::make($request->senha);
            $usuario->token = '';
            $usuario->save();
            
            return response()->json(['message' => 'Senha alterada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao alterar a senha: ' . $e->getMessage()], 400);
        }
    }
    
}


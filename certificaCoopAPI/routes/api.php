<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CooperativaController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\QuestaoController;
use App\Http\Controllers\OpcaoController;
use App\Http\Controllers\ProvaController;
use App\Http\Controllers\TransacaoController;
use App\Http\Controllers\HistoricoProvaController;
use App\Http\Controllers\HistoricoProvaMateriaController;
use App\Http\Controllers\PdfController;
use App\Mail\EnvioEmails;
use Illuminate\Support\Facades\Mail;

/*
--------------------------------------------------------------------------
 API Routes
--------------------------------------------------------------------------

 Here is where you can register API routes for your application. These
 routes are loaded by the RouteServiceProvider and all of them will
 be assigned to the "api" middleware group. Make something great!

*/

Route::prefix('usuarios')->group(function () {
    Route::get('/', [UsuarioController::class, 'listarTodos']); // Listar usuários
    Route::get('/{id}', [UsuarioController::class, 'mostrar']); // Exibir usuário específico
    Route::post('/', [UsuarioController::class, 'cadastrar']); // Cadastrar usuário
    Route::post('/login', [UsuarioController::class, 'login']); // Logar usuário
    Route::put('/gerarToken/{id}', [UsuarioController::class, 'gerarToken']); // Logar usuário
    Route::put('/{id}', [UsuarioController::class, 'atualizar']); // Atualizar usuário
    Route::put('/atualizarSenha/{id}', [UsuarioController::class, 'atualizarSenha']); // Atualizar senha usuário
    Route::post('/alterarSenha', [UsuarioController::class, 'alterarSenha']); // Atualizar senha usuário
    Route::delete('/{id}', [UsuarioController::class, 'deletar']); // Deletar usuário
});


Route::prefix('cooperativas')->group(function () {
    Route::get('/', [CooperativaController::class, 'listarTodos']); // Listar todas as cooperativas
    Route::get('/{id}', [CooperativaController::class, 'mostrar']); // Exibir cooperativa específica
    Route::post('/', [CooperativaController::class, 'cadastrar']); // Cadastrar cooperativa
    Route::put('/{id}', [CooperativaController::class, 'atualizar']); // Atualizar cooperativa
    Route::delete('/{id}', [CooperativaController::class, 'deletar']); // Deletar cooperativa
});

Route::prefix('materias')->group(function () {
    Route::get('/', [MateriaController::class, 'listarTodos']); // Listar todas as matérias
    Route::get('/{id}', [MateriaController::class, 'mostrar']); // Exibir matéria específica
    Route::post('/', [MateriaController::class, 'cadastrar']); // Cadastrar matéria
    Route::put('/{id}', [MateriaController::class, 'atualizar']); // Atualizar matéria
    Route::delete('/{id}', [MateriaController::class, 'deletar']); // Deletar matéria
});

Route::prefix('questoes')->group(function () {
    Route::get('/', [QuestaoController::class, 'listarTodos']); // Listar todas as questões
    Route::get('/{id}', [QuestaoController::class, 'mostrar']); // Exibir questão específica
    Route::post('/', [QuestaoController::class, 'cadastrarQuestao']); // Cadastrar questão
    Route::put('/{id}', [QuestaoController::class, 'atualizar']); // Atualizar questão
    Route::delete('/{id}', [QuestaoController::class, 'deletar']); // Deletar questão
});

Route::prefix('opcoes')->group(function () {
    Route::get('/', [OpcaoController::class, 'listarTodos']); // Listar todas as opções
    Route::get('/{id}', [OpcaoController::class, 'mostrar']); // Exibir opção específica
    Route::post('/', [OpcaoController::class, 'cadastrar']); // Cadastrar opção
    Route::put('/{id}', [OpcaoController::class, 'atualizar']); // Atualizar opção
    Route::delete('/{id}', [OpcaoController::class, 'deletar']); // Deletar opção
});

Route::prefix('provas')->group(function () {
    Route::get('/', [ProvaController::class, 'retornarProvas']); // Listar todas as provas
    Route::get('/{id}', [ProvaController::class, 'mostrar']); // Exibir prova específica
    Route::post('/', [ProvaController::class, 'cadastrar']); // Cadastrar prova
    Route::post('/gerarProva/{id}', [ProvaController::class, 'gerarProva']); // Cadastrar prova
    Route::put('/{id}', [ProvaController::class, 'atualizar']); // Atualizar prova
    Route::delete('/{id}', [ProvaController::class, 'deletar']); // Deletar prova
});

Route::prefix('transacoes')->group(function () {
    Route::post('/cartaoCredito', [TransacaoController::class, 'criarPedidoPagarCartao']); // Rota para a função criada na TransacaoController
    Route::get('/listarTransacoes/{id}', [TransacaoController::class, 'listarTransacoesPorUsuario']); // Rota para a função criada na TransacaoController
});

Route::prefix('historicoProva')->group(function () {
    Route::post('/', [HistoricoProvaController::class, 'cadastrarHistoricoProva']); // Cadastrar histórico de prova
    Route::get('/{id}', [HistoricoProvaController::class, 'listarProvasUsuario']); // Cadastrar histórico de prova
    Route::get('/codigo/{id}', [HistoricoProvaController::class, 'dadosProvaEspecifica']); // Cadastrar histórico de prova
});

Route::prefix('historicoProvaMateria')->group(function () {
    Route::post('/', [HistoricoProvaMateriaController::class, 'cadastrarHistoricoMateria']); // Cadastrar histórico de prova por matéria
    Route::get('/{id}', [HistoricoProvaMateriaController::class, 'detalharProva']); // Exibir histórico prova Materia específica
});

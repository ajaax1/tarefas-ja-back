<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('usuarios', 'App\Http\Controllers\UserController');
    Route::apiResource('categorias', 'App\Http\Controllers\CategoriaController');
    Route::apiResource('tarefas', 'App\Http\Controllers\TarefaController');
    Route::post('/logout', 'App\Http\Controllers\AuthController@logout');
    Route::get('/verificar-token', function (Request $request) {
        $currentToken = $request->bearerToken();
        return response()->json([
            'current_token' => $currentToken,
        ]);
    });
    Route::get('/pesquisa/{valor}/{id}', 'App\Http\Controllers\TarefaController@pesquisasPendentes');
    Route::get('/pesquisa/tarefas-realizadas/{valor}/{id}', 'App\Http\Controllers\TarefaController@pesquisasConcluida');
    Route::put('/tarefas/concluir/{id}','App\Http\Controllers\TarefaController@concluir');
    Route::get('/tarefas-por-usuario/{id}','App\Http\Controllers\TarefaController@tarefasPorUsuario');
    Route::post('/realizar-tarefas',    'App\Http\Controllers\TarefaController@realizarTarefas');
    Route::post('/deletar-tarefas', 'App\Http\Controllers\TarefaController@deletarTarefas');
    Route::get('/tarefas-realizadas-por-usuario/{id}','App\Http\Controllers\TarefaController@tarefasRealizadasPorUsuario');
});
Route::post('/esqueceu-senha', 'App\Http\Controllers\UserController@verificarEmail');
Route::post('/mudar-senha', 'App\Http\Controllers\EmailController@mudarSenha');
Route::post('/verificar-token', 'App\Http\Controllers\EmailController@verificarSenhaToken');
Route::post('/register', 'App\Http\Controllers\UserController@store');
Route::post('/login', 'App\Http\Controllers\AuthController@login');

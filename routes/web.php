<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LyLoginController;
use App\Http\Controllers\LyAlunoController;
use App\Http\Controllers\LyNotaController;
use App\Http\Controllers\LyDisciplinaController;
use App\Http\Controllers\LySimuladorNotaFormulaController;
use App\Http\Controllers\GraficoController;
use App\Http\Middleware\AuthMiddleware;


// PRIMEIRA ROTA - ROTA DE LOGIN
Route::get('/', function () {
        if(session()->has('aluno')) {
                return redirect()->route('menu');
        }
        return view('login');
});

Route::middleware([AuthMiddleware::class])->group(function () {

        // LOGIN GET
        // Caso o aluno já tenha logado e acesse a rota de login novamente, ele permanecerá logado, considerando tempo de session definida
        Route::get('/login', function () {
        if(session()->has('aluno')) {
                return redirect()->route('menu');
        }
        return view('login');
        })->name('loginGET');

        // LOGIN POST
        Route::post('/login', [LyLoginController::class, 'login'])
        ->name('loginPOST');

        // LOGOUT GET
        Route::get('/logout', [LyLoginController::class, 'logout'])
        ->name('logout');

        // MENU GET
        Route::get('/menu', function () {
                if (!session()->has('aluno')) {
                        return redirect()->route('loginGET');
                }

        // Armazena os dados da sessao nas variaveis
        $aluno = session('aluno');
        $curso = session('curso');
        $notas = session('notas');
        $formula_nm = session('formula_nm');
        $formula_mp = session('formula_mp');

        // Pega ano e semestre para selecionar fórmula corretamente lá na frente.
        $ano = session('anos');
        $semestre = session('semestres');

        // Passa os dados para a view
        return view('menu', compact('aluno', 'curso', 'notas', 'formula_nm', 'formula_mp', 'ano', 'semestre'));
        })->name('menu');

        // Retornar Notas
        Route::match(['get', 'post'], '/notas', [LyDisciplinaController::class, 'getNotas'])->name('getNotas');

        // Simulacao
        Route::match(['get', 'post'],'/simular', [LySimuladorNotaFormulaController::class, 'simular'])->name('simular');

        // Seleção de notas para serem mostradas na tabela
        Route::match(['get', 'post'], '/selecionar-notas', [LyAlunoController::class, 'getNotaAnoSemestreFromAluno'])->name('selecionar-notas');

        // Verifica Disciplinas
        Route::post('/verificar-disciplinas', [LyAlunoController::class, 'verificarDisciplinas'])
        ->name('verificar-disciplinas');

        // LOGOUT E LIMPA DADOSS DA SESSAO - EM CASOS DE ERRO 419
        Route::get('/logout-and-clear', function () {
                Session::flush();
                return redirect()->route('loginGET');
        })->name('logoutAndClear');
});
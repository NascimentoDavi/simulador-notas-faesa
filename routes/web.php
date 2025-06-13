<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LyLoginController;
use App\Http\Controllers\LyAlunoController;
use App\Http\Controllers\LyNotaController;
use App\Http\Controllers\LyDisciplinaController;
use App\Http\Controllers\LySimuladorNotaFormulaController;
use App\Http\Controllers\GraficoController;
use App\Http\Middleware\AuthMiddleware;


Route::get('/', function () {
    if(session()->has('aluno')) {
        return redirect()->route('menu');
    }
    return view('login');
})->name('beginning');

// LOGIN GET (não deve ter middleware!)
Route::get('/login', function () {
    if(session()->has('aluno')) {
        return redirect()->route('menu');
    }
    return view('login');
})->name('loginGET');

// LOGIN POST
Route::post('/login', [LyLoginController::class, 'login'])->name('loginPOST');

// LOGOUT GET (também fora do middleware)
Route::get('/logout', [LyLoginController::class, 'logout'])->name('logout');

// ROTAS PROTEGIDAS
Route::middleware([AuthMiddleware::class])->group(function () {
    Route::get('/menu', function () {
        if (!session()->has('aluno')) {
            return redirect()->route('loginGET')->with('message', 'Sessão expirada. Faça login novamente.');
        }

        // Armazena os dados da sessao nas variáveis
        $aluno = session('aluno');
        $curso = session('curso');
        $notas = session('notas');
        $formula_nm = session('formula_nm');
        $formula_mp = session('formula_mp');
        $ano = session('anos');
        $semestre = session('semestres');

        return view('menu', compact('aluno', 'curso', 'notas', 'formula_nm', 'formula_mp', 'ano', 'semestre'));
    })->name('menu');

    Route::match(['get', 'post'], '/notas', [LyDisciplinaController::class, 'getNotas'])->name('getNotas');

    Route::match(['get', 'post'], '/notas-por-periodo/{aluno}/{ano}/{semestre}', [LyDisciplinaController::class, 'getNotaAnoSemestre'])->name('getNotasAnoSemestre');

    Route::match(['get', 'post'],'/simular', [LySimuladorNotaFormulaController::class, 'simular'])->name('simular');

    Route::match(['get', 'post'], '/selecionar-notas', [LyAlunoController::class, 'getNotaAnoSemestreFromAluno'])->name('selecionar-notas');

    Route::post('/verificar-disciplinas', [LyAlunoController::class, 'verificarDisciplinas'])->name('verificar-disciplinas');
});

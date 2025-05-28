<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LyLoginController;
use App\Http\Controllers\LyAlunoController;
use App\Http\Controllers\LyNotaController;
use App\Http\Controllers\LyDisciplinaController;
use App\Http\Controllers\LySimuladorNotaFormulaController;
use App\Http\Controllers\GraficoController;
use App\Http\Middleware\AuthMiddleware;


// Primeira Rota
Route::get('/', function () {
if(session()->has('aluno')) {
        return redirect()->route('menu');
}
return view('login');
})->name('beginning');


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

        Route::match(['get', 'post'], '/notas', [LyDisciplinaController::class, 'getNotas'])->name('getNotas');

        Route::match(['get', 'post'], '/notas-por-periodo/{aluno}/{ano}/{semestre}', [LyDisciplinaController::class, 'getNotaAnoSemestre'])->name('getNotasAnoSemestre');

        Route::match(['get', 'post'],'/simular', [LySimuladorNotaFormulaController::class, 'simular'])->name('simular');

        // Seleção de notas para serem mostradas na tabela
        Route::match(['get', 'post'], '/selecionar-notas', [LyAlunoController::class, 'getNotaAnoSemestreFromAluno'])->name('selecionar-notas');
});
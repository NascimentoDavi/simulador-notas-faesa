<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LyLoginController;
use App\Http\Controllers\LyNotaController;
use App\Http\Controllers\LyDisciplinaController;
use App\Http\Controllers\LySimuladorNotaFormulaController;
use App\Http\Controllers\GraficoController;
use App\Http\Middleware\AuthMiddleware;


// Primeira Rota
Route::get('/', function () {
return view('login');
})->name('beginning');


Route::middleware([AuthMiddleware::class])->group(function () {


        // LOGIN GET
        Route::get('/login', function () {
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
                        return redirect()->route('login');
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

        // Rota para retornar o gráfico
        Route::match(['get', 'post'], '/grafico', [GraficoController::class, 'gerarGrafico']);
});
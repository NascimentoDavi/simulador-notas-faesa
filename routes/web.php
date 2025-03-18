<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LyLoginController;
use App\Http\Controllers\LyNotaController;
use App\Http\Controllers\LyDisciplinaController;
use App\Http\Controllers\LySimuladorNotaFormulaController;
use App\Http\Middleware\AuthMiddleware;

Route::get('/', function () {
return view('login');
})->name('beginning');

Route::middleware([AuthMiddleware::class])->group(function () {

        Route::post('/login', [LyLoginController::class, 'login'])
        ->name('login');

        Route::get('/login', function () {
        return view('login');
        })->name('beginning');

        Route::get('/logout', [LyLoginController::class, 'logout'])
        ->name('logout');

        Route::get('/menu', function () {
        if (!session()->has('aluno')) {
        return redirect()->route('login');
        }

        $aluno = session('aluno');
        $curso = session('curso');
        $notas = session('notas');
        $formula_nm = session('formula_nm');
        $formula_mp = session('formula_mp');

        // Passa os dados para a view
        return view('menu', compact('aluno', 'curso', 'notas', 'formula_nm', 'formula_mp'));
        })->name('menu');

        Route::match(['get', 'post'], '/notas', [LyDisciplinaController::class, 'getNotas'])->name('getNotas');

        Route::match(['get', 'post'], '/notas-por-periodo/{aluno}/{ano}/{semestre}', [LyDisciplinaController::class, 'getNotaAnoSemestre'])->name('getNotasAnoSemestre');

        Route::post('/simular', [LySimuladorNotaFormulaController::class, 'simular'])->name('simular');
        
});
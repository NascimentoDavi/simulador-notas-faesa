<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LyNotaController;
use App\Http\Controllers\LySimuladorNotaFormulaController;
use App\Http\Middleware\AuthMiddleware;

Route::get('/', function () {
    return view('login');
})->name('beginning');

Route::middleware([AuthMiddleware::class])->group(function () {

    Route::post('/login', [LoginController::class, 'login'])
            ->name('login');

    Route::get('/login', function () {
            return view('login');
            })->name('beginning');

    Route::get('/logout', [LoginController::class, 'logout'])
            ->name('logout');

    Route::get('/menu', function () {
                if (!session()->has('aluno')) {
                        return redirect()->route('login');
                }

                $notasPivot = session('notasPivot');
                $aluno = session('aluno');
                $curso = session('curso');
                $formula_nm = session('formula_nm');
                $formula_mp = session('formula_mp');

                // Passa os dados para a view
                return view('menu', compact('notasPivot', 'aluno', 'curso', 'formula_nm', 'formula_mp'));
        })->name('menu');

        Route::match(['get', 'post'], '/notas', [LyNotaController::class, 'getNotas'])->name('getNotas');

        Route::post('/simular', [LySimuladorNotaFormulaController::class, 'simular'])->name('simular');
});
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

        // Rotas de login
        Route::get('/login', fn() => view('login'))->name('beginning');
        Route::post('/login', [LoginController::class, 'login'])->name('login');
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

        // Menu
        Route::get('/menu', function () {
                if (!session()->has('aluno')) {
                        return redirect()->route('login');
                }

                return view('menu', [
                        'notasPivot' => session('notasPivot'),
                        'aluno' => session('aluno'),
                        'disciplinaAluno' => session('disciplinaAluno'),
                        'curso' => session('curso'),
                        'formula_nm' => session('formula_nm'),
                        'formula_mp' => session('formula_mp'),
                ]);
        })->name('menu');

        // Outras rotas
        Route::match(['get', 'post'], '/notas', [LyNotaController::class, 'getNotas'])->name('getNotas');
        Route::post('/simular', [LySimuladorNotaFormulaController::class, 'simular'])->name('simular');
});

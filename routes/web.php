<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\AuthMiddleware;

Route::get('/', function () {
    return view('login');
})->name('beginning');

// Route::middleware([AuthMiddleware::class])->group(function () {

//     Route::post('/login', [LoginController::class, 'login'])
//     ->name('login');

//     // If the user try to reload the login page
//     Route::get('/login', function () {
//         return view('login');
//     })->name('beginning');

//     Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

//     Route::get('/menu', function () {
//         return view('menu');
//     })->name('menu');

// });

Route::post('/login', [LoginController::class, 'login'])
        ->name('login');

Route::get('/login', function () {
        return view('login');
        })->name('beginning');

Route::get('/logout', [LoginController::class, 'logout'])
        ->name('logout');

Route::get('/menu', function () {
        // Recupera os dados da sessão
        $notasPivot = session('notasPivot');
        $aluno = session('aluno');
        $curso = session('curso');

        // Passa os dados para a view
        return view('menu', compact('notasPivot', 'aluno', 'curso'));
        })->name('menu');
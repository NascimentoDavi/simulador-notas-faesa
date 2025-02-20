<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\AuthMiddleware;

Route::get('/', function () {
    return view('login');
})->name('beginning');

Route::middleware([AuthMiddleware::class])->group(function () {

    Route::post('/login', [LoginController::class, 'login'])
    ->name('login');

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/menu', function () {
        return view('menu');
    })->name('menu');

});

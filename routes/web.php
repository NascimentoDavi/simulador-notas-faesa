<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\CheckUserExists;

Route::get('/', function () {
    return view('login');
})->name('beginning');

Route::post('/login', [LoginController::class, 'login'])
    ->middleware('check-user')
    ->name('login');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/menu', [])

// Route::middleware(['web', 'Auth.Login'])->group(function () {

//     Route::get('/menu', function () {
//         return view('menu');
//     })->name('menu');
    
// });
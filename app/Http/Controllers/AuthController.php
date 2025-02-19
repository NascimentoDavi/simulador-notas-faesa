<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LyPessoa;


class AuthController extends Controller
{
    public static function validateLogin(Request $request)
    {
        $credenciais = [
            'Login' => $request->login,
            'Senha' => $request->senha,
        ];

        // Add Password Validation
        $pessoa = LyPessoa::where('WINUSUARIO', "=", "FAESA\\{$credenciais['Login']}")->first();

        return $pessoa;
    }
}

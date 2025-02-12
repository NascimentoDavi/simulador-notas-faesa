<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{


    public function login(Request $request)
    {
        $credenciais = [
            'Login' => $request->login,
            'Senha' => $request->senha
        ];
        // $user = User::where('Login', '=', $credenciais['Login'])->first();
        return view('menu');
    }

    public function logout(Request $request)
    {

        return redirect()->route('beginning');
    }
}
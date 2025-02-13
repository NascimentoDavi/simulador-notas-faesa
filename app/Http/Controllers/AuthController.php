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

        // Current date
        $anoAtual = date('Y');
        $semestreAtual = (date('n') <= 6) ? '1' : '2';

        $pessoa = LyPessoa::where('WINUSUARIO', '=', 'FAESA\\' . $credenciais['Login'])->first();
        $aluno = LyAluno::where('NOME_COMPL', '=', $pessoa['NOME_COMPL'])->first();
        $notas = LyNota::where('ALUNO', '=', $aluno['ALUNO'])
                        ->where('ANO', '=', $anoAtual)
                        ->where('SEMESTRE', '=', $semestreAtual)
                        ->get(['DISCIPLINA', 'CONCEITO']);

        // $user = User::where('Login', '=', $credenciais['Login'])->first();

        return view('menu', compact('notas'));
    }

    public function logout(Request $request)
    {
        return redirect()->route('beginning');
    }
}
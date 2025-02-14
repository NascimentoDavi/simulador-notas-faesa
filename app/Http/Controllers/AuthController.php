<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\LyPessoa;
use App\Models\LyAluno;
use App\Models\LyNota;
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
        // $anoAtual = date('Y');
        // $semestreAtual = (date('n') <= 6) ? '1' : '2';
        $anoAtual = '2024';
        $semestreAtual = '2';

        $pessoa = LyPessoa::where('WINUSUARIO', "=", "FAESA\\{$credenciais['Login']}")->first();
        $aluno = LyAluno::where('NOME_COMPL', '=', $pessoa['NOME_COMPL'])->first();
        $notas = LyNota::join('LY_DISCIPLINA', 'LY_NOTA.DISCIPLINA', '=', 'LY_DISCIPLINA.DISCIPLINA')
                ->where('LY_NOTA.ALUNO', '=', $aluno['ALUNO'])
                ->where('LY_NOTA.ANO', '=', $anoAtual)
                ->where('LY_NOTA.SEMESTRE', '=', $semestreAtual)
                ->whereIn('LY_NOTA.PROVA', ['C1', 'C2', 'C3'])
                ->get(['LY_NOTA.DISCIPLINA', 'LY_NOTA.PROVA', 'LY_NOTA.CONCEITO', 'LY_DISCIPLINA.NOME AS NOME_DISCIPLINA']);

        // Transform the data to have PROVA types as columns
        $notasPivot = $notas->groupBy('DISCIPLINA')->map(function ($group) {
            $groupedData = [
                'DISCIPLINA' => $group->first()->DISCIPLINA,
                'NOME_DISCIPLINA' => $group->first()->NOME_DISCIPLINA,
                'C1' => null,
                'C2' => null,
                'C3' => null
            ];

            foreach ($group as $nota) {
                if ($nota->PROVA == 'C1') {
                    $groupedData['C1'] = $nota->CONCEITO;
                } elseif ($nota->PROVA == 'C2') {
                    $groupedData['C2'] = $nota->CONCEITO;
                } elseif ($nota->PROVA == 'C3') {
                    $groupedData['C3'] = $nota->CONCEITO;
                }
            }

            return (object) $groupedData;
        });


        // Se não encontrar a pessoa, retorna erro
        if (!$pessoa) {
            return redirect()->back()->withErrors(['login' => 'Usuário não encontrado. Verifique suas credenciais.']);
        }

        // $user = User::where('Login', '=', $credenciais['Login'])->first();

        return view('menu', compact('notasPivot'));
    }

    public function logout(Request $request)
    {
        return redirect()->route('beginning');
    }
}
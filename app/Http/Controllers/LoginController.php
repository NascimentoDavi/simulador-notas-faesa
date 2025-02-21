<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ValidationController;
use App\Models\LyPessoa;
use App\Models\LyAluno;
use App\Models\LyNota;
use App\Models\LyCurso;
use Illuminate\Support\Facades\View;

class LoginController extends Controller
{
    public function login(Request $request)
    {        
        // Se for possivel logar como aluno, codigo daqui pra baixo funcionará
        $pessoa = LyPessoa::where('WINUSUARIO', "=", "FAESA\\{$request->input('login')}")->first();

        $request->merge(['pessoa' => $pessoa]);

        // $pessoa = $request->get('pessoa');

        $anoAtual = '2024';
        $semestreAtual = '2';

        $aluno = LyAluno::where('NOME_COMPL', '=', $pessoa['NOME_COMPL'])->first();

        $curso = LyCurso::where('CURSO', '=', $aluno['CURSO'])->first();

        $notas = LyNota::join('LY_DISCIPLINA', 'LY_NOTA.DISCIPLINA', '=', 'LY_DISCIPLINA.DISCIPLINA')
            ->where('LY_NOTA.ALUNO', '=', $aluno['ALUNO'])
            ->where('LY_NOTA.ANO', '=', $anoAtual)
            ->where('LY_NOTA.SEMESTRE', '=', $semestreAtual)
            ->whereIn('LY_NOTA.PROVA', ['C1', 'C2', 'C3'])
            ->get(['LY_NOTA.DISCIPLINA', 'LY_NOTA.PROVA', 'LY_NOTA.CONCEITO', 'LY_DISCIPLINA.NOME AS NOME_DISCIPLINA']);

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

        session([
            'notasPivot' => $notasPivot,
            'aluno' => $aluno,
            'curso' => $curso,
        ]);

        return redirect()->intended('/menu');
    }

    public function logout(Request $request)
    {
        return redirect()->route('beginning');
    }
}

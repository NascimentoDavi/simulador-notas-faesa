<?php

namespace App\Http\Controllers;

use App\Models\LyNota;
use App\Models\LyNotaHistMatr;
use Illuminate\Http\Request;

class LyNotaController extends Controller
{
    public function getNotasPivot($aluno, $anoAtual, $semestreAtual)
    {
        if(session('curso')->CURSO == '3006') {
            $notas = LyNota::join('LY_DISCIPLINA', 'LY_NOTA.DISCIPLINA', '=', 'LY_DISCIPLINA.DISCIPLINA')
            ->where('LY_NOTA.ALUNO', '=', $aluno['ALUNO'])
            ->where('LY_NOTA.ANO', '=', $anoAtual)
            ->where('LY_NOTA.SEMESTRE', '=', $semestreAtual)
            ->whereIn('LY_NOTA.PROVA', ['C1', 'C2', 'C3'])
            ->get([
                'LY_NOTA.DISCIPLINA', 
                'LY_NOTA.PROVA', 
                'LY_NOTA.CONCEITO', 
                'LY_DISCIPLINA.NOME AS NOME_DISCIPLINA'
            ]);
        } else {
            $notas = LyNotaHistMatr::join('LY_DISCIPLINA', 'LY_NOTA_HISTMATR.DISCIPLINA', '=', 'LY_DISCIPLINA.DISCIPLINA')
            ->where('LY_NOTA_HISTMATR.ALUNO', '=', $aluno['ALUNO'])
            ->where('LY_NOTA_HISTMATR.ANO', '=', $anoAtual)
            ->where('LY_NOTA_HISTMATR.SEMESTRE', '=', $semestreAtual)
            ->whereIn('LY_NOTA_HISTMATR.NOTA_ID', ['C1', 'C2', 'C3'])
            ->get([
                'LY_NOTA_HISTMATR.DISCIPLINA',
                'LY_NOTA_HISTMATR.NOTA_ID',
                'LY_NOTA_HISTMATR.CONCEITO', 
                'LY_DISCIPLINA.NOME AS NOME_DISCIPLINA'
            ]);
        }

        return $notas->groupBy('DISCIPLINA')->map(function ($group) {
            $groupedData = [
                'DISCIPLINA' => $group->first()->DISCIPLINA,
                'NOME_DISCIPLINA' => $group->first()->NOME_DISCIPLINA,
                'C1' => null,
                'C2' => null,
                'C3' => null
            ];

            if(session('curso')->CURSO == '3006') {
                foreach ($group as $nota) {
                    if ($nota->PROVA == 'C1') {
                        $groupedData['C1'] = $nota->CONCEITO;
                    } elseif ($nota->PROVA == 'C2') {
                        $groupedData['C2'] = $nota->CONCEITO;
                    } elseif ($nota->PROVA == 'C3') {
                        $groupedData['C3'] = $nota->CONCEITO;
                    }
                }
            } else {
                foreach ($group as $nota) {
                    if ($nota->NOTA_ID == 'C1') {
                        $groupedData['C1'] = $nota->CONCEITO;
                    } elseif ($nota->NOTA_ID == 'C2') {
                        $groupedData['C2'] = $nota->CONCEITO;
                    } elseif ($nota->NOTA_ID == 'C3') {
                        $groupedData['C3'] = $nota->CONCEITO;
                    }
                }
            }
            return (object) $groupedData;
        });
    }

    public function getNotas(Request $request)
    {
        $aluno = session('aluno');
        $ano = $request->input('ano');
        $semestre = $request->input('semestre');

    }
}

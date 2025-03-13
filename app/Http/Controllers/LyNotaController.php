<?php

namespace App\Http\Controllers;

use App\Models\LyNota;
use Illuminate\Http\Request;

class LyNotaController extends Controller
{
    public function getNotasPivot($aluno, $anoAtual, $semestreAtual)
    {
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

        return $notas->groupBy('DISCIPLINA')->map(function ($group) {
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
    }

    public function getNotas(Request $request)
    {
        $aluno = session('aluno');
        $ano = $request->input('ano');
        $semestre = $request->input('semestre');

        /*return getNotasPivot($aluno, $ano, $semestre);*/
    }
}

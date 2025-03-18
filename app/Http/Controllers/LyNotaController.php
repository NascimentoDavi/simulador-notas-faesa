<?php

namespace App\Http\Controllers;

use App\Models\LyNota;
use Illuminate\Http\Request;

class LyNotaController extends Controller
{
    public function getNotas(Request $request)
    {
        // Obtendo as variáveis necessárias
        $aluno = $request->input('aluno');
        $anoAtual = date('Y'); // Exemplo, você pode passar isso de acordo com sua necessidade
        $semestreAtual = 1; // Exemplo, ajuste conforme seu caso
        $curso = $aluno['CURSO'];

        $notas = [];

        if ($curso == '3006') {
            // Caso o curso seja '3006', utilizar a tabela 'LY_NOTA'
            $notas = DB::table('LY_NOTA')
                ->join('LY_DISCIPLINA', 'LY_NOTA.DISCIPLINA', '=', 'LY_DISCIPLINA.DISCIPLINA')
                ->where('LY_NOTA.ALUNO', '=', $aluno['ALUNO'])
                ->where('LY_NOTA.ANO', '=', $anoAtual)
                ->where('LY_NOTA.SEMESTRE', '=', $semestreAtual)
                ->whereIn('LY_NOTA.PROVA', ['C1', 'C2', 'C3'])
                ->select('LY_NOTA.DISCIPLINA', 'LY_NOTA.PROVA', 'LY_NOTA.CONCEITO', 'LY_DISCIPLINA.NOME AS NOME_DISCIPLINA')
                ->get();
        } else {
            // Caso o curso não seja '3006', utilizar a tabela 'LY_NOTA_HISTMATR'
            $notas = DB::table('LY_NOTA_HISTMATR')
                ->join('LY_DISCIPLINA', 'LY_NOTA_HISTMATR.DISCIPLINA', '=', 'LY_DISCIPLINA.DISCIPLINA')
                ->where('LY_NOTA_HISTMATR.ALUNO', '=', $aluno['ALUNO'])
                ->where('LY_NOTA_HISTMATR.ANO', '=', $anoAtual)
                ->where('LY_NOTA_HISTMATR.SEMESTRE', '=', $semestreAtual)
                ->whereIn('LY_NOTA_HISTMATR.NOTA_ID', ['C1', 'C2', 'C3'])
                ->select('LY_NOTA_HISTMATR.DISCIPLINA', 'LY_NOTA_HISTMATR.NOTA_ID', 'LY_NOTA_HISTMATR.CONCEITO', 'LY_DISCIPLINA.NOME AS NOME_DISCIPLINA')
                ->get();
        }

        $notasAgrupadas = $notas->groupBy('DISCIPLINA')->map(function ($group) {
            $groupedData = [
                'DISCIPLINA' => $group->first()->DISCIPLINA,
                'NOME_DISCIPLINA' => $group->first()->NOME_DISCIPLINA,
                'C1' => null,
                'C2' => null,
                'C3' => null
            ];

            // Verificar se é o curso '3006' para aplicar a lógica de PROVA ou NOTA_ID
            foreach ($group as $nota) {
                if ($nota->PROVA == 'C1' || $nota->NOTA_ID == 'C1') {
                    $groupedData['C1'] = $nota->CONCEITO;
                } elseif ($nota->PROVA == 'C2' || $nota->NOTA_ID == 'C2') {
                    $groupedData['C2'] = $nota->CONCEITO;
                } elseif ($nota->PROVA == 'C3' || $nota->NOTA_ID == 'C3') {
                    $groupedData['C3'] = $nota->CONCEITO;
                }
            }

            return $groupedData;
        });

        // Retornar o array com os dados agrupados
        return response()->json($notasAgrupadas);
    }

    public function getNotasPorPeriodo()
    {
        //
    }
}
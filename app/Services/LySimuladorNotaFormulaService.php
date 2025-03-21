<?php

namespace App\Services;

use App\Models\LyDisciplina;

class LySimuladorNotaFormulaService
{

    /**
     * Simula as notas e calcula as médias.
     *
     * @param float $c1 Nota da prova c1
     * @param float $c2 Nota da prova c2
     * @param float $c3 Nota da prova c3
     * @return array Retorna as médias formatadas
     */
    public function simularNotas($c1, $c2, $c3)
    {
        // // Calculando a média das provas
        // $mediaAritmetica = round(($c1 + $c2 + $c3) / 3, 2);
            
        // // Cálculo da média da prova final
        // $mediaProvaFinal = round((5 - ($mediaAritmetica * 0.6)) / 0.4, 2);

        // // Ajustando a média da prova final
        // $mediaProvaFinal = ceil($mediaProvaFinal * 20) / 20;
        
        // return [
        //     'mediaAritmetica' => number_format($mediaAritmetica, 2, '.', ''),
        //     'mediaProvaFinal' => number_format($mediaProvaFinal, 2, '.', ''),
        // ];

        $formula = LyDisciplina::where('DISCIPLINA', $disciplina)
            ->where('ANO', '2025')
            ->first(['FORMULA_MF1', 'FL_FIELD_01']);

        if (!$formula) {
            return response()->json(['error' => 'Disciplina não encontrada.'], 404);
        }

        $formulaMP = $formula->FORMULA_MF1;
        $formulaNM = $formula->FL_FIELD_01;

        if (!$formulaMP || !$formulaNM) {
            return response()->json(['error' => 'Fórmula não encontrada para esta disciplina.'], 500);
        }

        // Substituir os valores de C1, C2 e C3 na fórmula
        $formulaMP = str_replace(['C1', 'C2', 'C3'], [$c1, $c2, $c3], $formulaMP);
        $formulaNM = str_replace(['C1', 'C2', 'C3'], [$c1, $c2, $c3], $formulaNM);

        try {
            $mediaAritmetica = eval("return ($formulaMP);");
            $mediaProvaFinal = eval("return ($formulaNM);");

            $mediaAritmetica = number_format((float) $mediaAritmetica, 2, '.', '');
            $mediaProvaFinal = number_format((float) $mediaProvaFinal, 2, '.', '');

        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Erro ao calcular a fórmula: ' . $e->getMessage()
            ], 500);
        }

        return response()->json([
            'mediaAritmetica' => $mediaAritmetica,
            'mediaProvaFinal' => $mediaProvaFinal,
            'debug' => [$mediaAritmetica, $mediaProvaFinal] // Adiciona os valores no JSON
        ]);
    }
}
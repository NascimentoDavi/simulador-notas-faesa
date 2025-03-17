<?php

namespace App\Http\Controllers;
use App\Models\LyDisciplina;

use Illuminate\Http\Request;

class LySimuladorNotaFormulaController extends Controller
{
    public function simular(Request $request)
    {
        $c1 = floatval($request->input('c1', 0));
        $c2 = floatval($request->input('c2', 0));
        $c3 = floatval($request->input('c3', 0));
        $disciplina = $request->input('disciplina');

        // Buscar a fórmula no banco
        $formula = LyDisciplina::where('DISCIPLINA', $disciplina)
                                ->where('ANO', '2025')
                                ->first(['FORMULA_MF1', 'FL_FIELD_01']);


        if (!$formula) {
            return response()->json(['error' => 'Disciplina não encontrada.'], 404);
        }


        $formulaMP = $formula->FORMULA_MF1;  // Ex: "(C1+C2+C3)/3"
        $formulaNM = $formula->FL_FIELD_01; // Ex: "(5-(((C1+C2+C3)/3)*0.6)/0.4)"

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


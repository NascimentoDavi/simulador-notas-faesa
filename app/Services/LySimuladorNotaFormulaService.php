<?php

namespace App\Services;

use App\Models\LyDisciplina;
use App\Models\LyTurma;
use App\Services\LyTurmaService;

class LySimuladorNotaFormulaService
{
    protected $turmaService;

    public function __construct(LyTurmaService $turmaService)
    {
        $this->turmaService = $turmaService;
    }

    /**
     * Simula as notas e calcula as médias truncando para duas casas decimais.
     *
     * @param float $c1 Nota da prova c1
     * @param float $c2 Nota da prova c2
     * @param float $c3 Nota da prova c3
     * @return \Illuminate\Http\JsonResponse
     */
    public function simularNotas($c1, $c2, $c3, $aluno, $disciplina, $ano, $semestre)
    {
        $turmas = $this->turmaService->getTurma($aluno, $disciplina, $ano, $semestre);
        $formula = $this->turmaService->getFormulaFromTurma($disciplina, $turmas, $ano, $semestre);

        // dd($formula);
        
        if (!$formula) {
            return response()->json(['error' => 'Disciplina não encontrada.'], 404);
        }

        $formulaArray = array_values($formula->toArray());
        $formulaMP = $formulaArray[0] ?? null;
        $formulaNM = $formulaArray[1] ?? null;

        if($formulaMP == null) {
            return null;
        }

        if ($formulaMP == null) {
            return response()->json(['error' => 'Fórmula não encontrada para esta turma.'], 500);
        }

        // Substitui os valores de C1, C2 e C3 na fórmula
        $formulaMP = str_replace(['C1', 'C2', 'C3'], [$c1, $c2, $c3], $formulaMP);
        $formulaNM = str_replace(['C1', 'C2', 'C3'], [$c1, $c2, $c3], $formulaNM);

        try {
            $mediaAritmetica = eval("return ($formulaMP);");
            $mediaProvaFinal = eval("return ($formulaNM);");

            // Truncamento para 2 casas decimais
            $mediaAritmetica = $this->truncar($mediaAritmetica, 2);

            if ($mediaAritmetica >= 7) {
                $mediaProvaFinal = '';
            } else {
                $mediaProvaFinal = $this->truncar($mediaProvaFinal, 2);
            }

        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Erro ao calcular a fórmula: ' . $e->getMessage()
            ], 500);
        }

        return response()->json([
            'mediaAritmetica' => $mediaAritmetica,
            'mediaProvaFinal' => $mediaProvaFinal,
            'debug' => [$mediaAritmetica, $mediaProvaFinal]
        ]);
    }

    /**
     * Trunca um número decimal para a quantidade desejada de casas decimais (sem arredondar).
     *
     * @param float $numero
     * @param int $casas
     * @return float
     */
    private function truncar($numero, $casas)
    {
        $fator = pow(10, $casas);
        return floor($numero * $fator) / $fator;
    }
}

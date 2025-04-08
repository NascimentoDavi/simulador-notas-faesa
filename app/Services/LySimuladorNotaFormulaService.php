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
     * Simula as notas e calcula as médias.
     *
     * @param float $c1 Nota da prova c1
     * @param float $c2 Nota da prova c2
     * @param float $c3 Nota da prova c3
     * @return array Retorna as médias formatadas
     */
    public function simularNotas($c1, $c2, $c3, $aluno, $disciplina, $ano)
    {
        // // FÓRMULA
        // $formula = $this
        // ->turmaService
        // ->getFormulaFromTurma($disciplina, $ano, $turma);

        $turmas = $this->turmaService->getTurma($aluno, $disciplina);

        $formula = $this->turmaService->getFormulaFromTurma($disciplina, $turmas);

        // dd($formula);

        if (!$formula) {
            return response()->json(['error' => 'Disciplina não encontrada.'], 404);
        }

        $formulaArray = array_values($formula->toArray());
        $formulaMP = $formulaArray[0] ?? null;
        $formulaNM = $formulaArray[1] ?? null;

        if (!$formulaMP || !$formulaNM) {
            return response()->json(['error' => 'Fórmula não encontrada para esta turma.'], 500);
        }

        // Substitui os valores de C1, C2 e C3 na fórmula
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
            'debug' => [$mediaAritmetica, $mediaProvaFinal]
        ]);
    }
}
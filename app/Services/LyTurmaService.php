<?php

namespace App\Services;

use App\Models\LyTurma;
use App\Models\LyMatricula;

class LyTurmaService
{
    // FORMULA DE CALCULO
    public function getFormulaFromTurma($disciplina, $turmas)
    {
        foreach ($turmas as $turma) {
            if ($turma['DISCIPLINA'] === $disciplina) {
                $formula = LyTurma::where('DISCIPLINA', $disciplina)
                    ->where('TURMA', $turma['TURMA'])
                    ->first(['FORMULA_MF1', 'FL_FIELD_01']);

                    // Caso não possua fórmula cadastrada
                    if($formula['FL_FIELD_01'] === NULL || empty($formula['FL_FIELD_01'])) {
                        $formula = LyTurma::where('DISCIPLINA', $disciplina)
                        ->where('TURMA', $turma['TURMA'])
                        ->first(['FORMULA_MF1', 'FORMULA_MF2']);

                        if ($formula && isset($formula['FORMULA_MF2'])) {
                            $formula['FORMULA_MF2'] = str_replace('+(AF*0.4)', '/0.4', $formula['FORMULA_MF2']);
                        }
                    }
                    return $formula;
            }
        }
        return null;
    }

    // GET TURMA
    public function getTurma($aluno, $disciplina)
    {
        $turmas = LyMatricula::where('DISCIPLINA', $disciplina)
            ->where('ALUNO', $aluno)
            ->whereIn('SIT_MATRICULA', ['Matriculado', 'Aprovado'])
            ->where('ANO', '2025')
            ->get(['TURMA', 'DISCIPLINA'])
            ->map(function ($turma) {
                $turma['DISCIPLINA'] = ucfirst(strtolower($turma['DISCIPLINA'])); // Garante a capitalização correta
                return $turma;
            })
            ->toArray();

        return $turmas;
    }
}
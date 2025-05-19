<?php


namespace App\Services;


use App\Models\LyTurma;
use App\Models\LyMatricula;


class LyTurmaService
{


    // FORMULA DE CÁLCULO
    public function getFormulaFromTurma($disciplina, $turmas, $ano, $semestre)
    {


        // Modified By Davi R : Add ano e semestre para filtragem de formulas.

        foreach ($turmas as $turma) {
            if ($turma['DISCIPLINA'] === $disciplina) {
                $formula = LyTurma::where('DISCIPLINA', $disciplina)
                    ->where('TURMA', $turma['TURMA'])
                    ->where('ANO', $ano)
                    ->where('SEMESTRE', $semestre)
                    ->first(['FORMULA_MF1', 'FL_FIELD_16']);
                    

                // Caso não possua fórmula cadastrada
                // if($formula['FL_FIELD_01'] === NULL || empty($formula['FL_FIELD_01'])) {
                //     $formula = LyTurma::where('DISCIPLINA', $disciplina)
                //     ->where('TURMA', $turma['TURMA'])
                //     ->first(['FORMULA_MF1', 'FORMULA_MF2']);

                //     if ($formula && isset($formula['FORMULA_MF2'])) {
                //         $formula['FORMULA_MF2'] = str_replace('+(AF*0.4)', '/0.4', $formula['FORMULA_MF2']);
                //     }
                // }

                // dd($formula);

                return $formula;
            }
        }
        return null;
    }


    // Retorna Turma a partir da Disciplina
    public function getTurma($aluno, $disciplina, $ano, $semestre)
    {
        $turmas = LyMatricula::where('DISCIPLINA', $disciplina)
            ->where('ALUNO', $aluno)
            
            ->where('SIT_MATRICULA', 'Matriculado') // Não utilizamos o valor da coluna 'Aprovado', pois pegamos somente as disciplinas do semestre atual

            ->where('ANO', $ano)

            ->where('SEMESTRE', $semestre)

            ->get(['TURMA', 'DISCIPLINA'])

            ->map(function ($turma) {
                $turma['DISCIPLINA'] = ucfirst(strtolower($turma['DISCIPLINA'])); // Garante a capitalização correta | Primeira letra maiúscula e restante minúsculo
                return $turma;
            })
            ->toArray();

        return $turmas;
    }

}
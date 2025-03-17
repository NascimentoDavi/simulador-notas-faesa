<?php

namespace App\Services;

use App\Models\LyMatricula;
use App\Models\LyDisciplina;
use App\Models\LyAluno;
use App\Models\LyNota;

class LyDisciplinaService
{
    public function getMatriculas($aluno)
    {
        return LyMatricula::where('ALUNO', '=', $aluno['ALUNO'])->get('DISCIPLINA');
    }

    public function getFormulaFromDisciplina($matriculas)
    {
        if($matriculas->isEmpty()){
            return null;
        }

        return LyDisciplina::where('DISCIPLINA', '=', $matriculas[0]->DISCIPLINA)
        ->first(['FORMULA_MF1', 'FORMULA_MF2']);
    }

    public function getNotas($aluno)
    {
        $matriculas = $this->getMatriculas($aluno);
        $notas = [];

        foreach ($matriculas as $matricula) {
            $nota = LyNota::join('ly_matricula', 'ly_matricula.ALUNO', '=', 'ly_nota.ALUNO')
                ->where('ly_nota.DISCIPLINA', '=', $matricula->DISCIPLINA)
                ->where('ly_nota.ANO', '=', $matricula->ANO)
                ->where('ly_nota.SEMESTRE', '=', $matricula->SEMESTRE)
                ->where('ly_matricula.ALUNO', '=', $aluno['ALUNO'])
                ->where('ly_matricula.SIT_MATRICULA', '=', 'Matriculado')
                ->get(['ly_nota.CONCEITO']);

            $notas[] = [
                'DISCIPLINA' => $matricula->DISCIPLINA,
                'ANO' => $matricula->ANO,
                'SEMESTRE' => $matricula->SEMESTRE,
                'NOTA' => $nota
            ];
        }

        return $notas;
    }

    // Pesquisar notas por ano e semestre
    public function getNotasAnoSemestre($aluno, $ano, $semestre)
    {
        $matriculas = $this->getMatriculas($aluno);
        
        $notas = [];

        if(ano !== date('Y')) {

        }

        foreach ($matriculas as $matricula) {

        //     $nota = LyNota::join('ly_matricula', 'ly_matricula.ALUNO', '=', 'ly_nota.ALUNO')
        //         ->where('ly_nota.DISCIPLINA', '=', $matricula->DISCIPLINA)
        //         ->where('ly_nota.ANO', '=', $ano)
        //         ->where('ly_nota.SEMESTRE', '=', $semestre)
        //         ->where('ly_matricula.ALUNO', '=', $aluno['ALUNO'])
        //         ->where('ly_matricula.SIT_MATRICULA', '=', 'Matriculado')
        //         ->get(['ly_nota.CONCEITO']);

        //     $notas[] = [
        //         'DISCIPLINA' => $matricula->DISCIPLINA,
        //         'ANO' => $matricula->ANO,
        //         'SEMESTRE' => $matricula->SEMESTRE,
        //         'NOTA' => $nota
        //     ];
        // }
        }
    }
}
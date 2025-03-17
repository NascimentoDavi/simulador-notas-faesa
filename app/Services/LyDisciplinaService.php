<?php

namespace App\Services;

use App\Models\LyMatricula;
use App\Models\LyDisciplina;
use App\Models\LyAluno;

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
}
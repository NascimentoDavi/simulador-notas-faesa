<?php

namespace App\Http\Controllers;

use App\Models\LyDisciplina;
use App\Models\LyMatricula;
use App\Models\LyAluno;
use Illuminate\Http\Request;

class LyDisciplinaController extends Controller
{
    public function getMatriculas($aluno)
    {
        $matriculas = LyMatricula::where('ALUNO', '=', $aluno['ALUNO'])->get('DISCIPLINA');
        return $matriculas;
    }


    public function getFormulaFromDisciplina($matriculas)
    {
        if ($matriculas->isEmpty()) {
            return null;
        }

        return LyDisciplina::where('DISCIPLINA', '=', $matriculas[0]->DISCIPLINA)
            ->first(['FORMULA_MF1', 'FORMULA_MF2']);
    }
}

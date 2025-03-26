<?php

namespace App\Services;

use App\Models\LyTurma;

class LyTurmaService
{
    // FORMULA DE CALCULO
    public function getFormulaFromTurma($disciplina, $ano)
    {
        return LyTurma::where('DISCIPLINA', $disciplina)
        ->where('ANO', $ano)
        ->first(['FORMULA_MF1', 'FL_FIELD_01']);
    }
}
<?php

namespace App\Services;

use App\Models\LyAluno;
use App\Models\LyCurso;

class LyAlunoService
{
    /**
     * Retorna o aluno a partir da pessoa
     */
    public function getAluno($pessoa)
    {

        // Caso o aluo tenha mais de uma matrícula, pega a mais recente
        // In case the student has more than one enrollment, it captures the most recent one

        return LyAluno::where('NOME_COMPL', '=', $pessoa->NOME_COMPL)
        ->latest('DT_INGRESSO')
        ->first();
    }

    /**
     * Retorna o curso de um aluno
     */
    public function getCursoFromAluno($aluno)
    {
        return LyCurso::where('CURSO', '=', $aluno['CURSO'])->first();
    }
}
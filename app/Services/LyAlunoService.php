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
        return LyAluno::where('NOME_COMPL', '=', $pessoa->NOME_COMPL)->first();
    }

    /**
     * Retorna o curso de um aluno
     */
    public function getCursoFromAluno($aluno)
    {
        return LyCurso::where('CURSO', '=', $aluno['CURSO'])->first();
    }
}
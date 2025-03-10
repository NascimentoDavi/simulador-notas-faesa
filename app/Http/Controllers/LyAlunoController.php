<?php

namespace App\Http\Controllers;

use App\Models\LyAluno;
use App\Models\LyCurso;
use Illuminate\Http\Request;

class LyAlunoController extends Controller
{
    public function getAluno($pessoa)
    {
        $aluno = LyAluno::where('NOME_COMPL', '=', $pessoa->NOME_COMPL)->first();
        return $aluno;
    }

    public function getCursoFromAluno($aluno)
    {
        $curso = LyCurso::where('CURSO', '=', $aluno['CURSO'])->first();
        return $curso;
    }
}
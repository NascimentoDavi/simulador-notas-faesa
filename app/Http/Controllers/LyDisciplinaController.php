<?php

namespace App\Http\Controllers;

use App\Models\LyDisciplina;
use App\Models\LyMatricula;
use App\Services\LyDisciplinaService;
use App\Models\LyAluno;
use Illuminate\Http\Request;

class LyDisciplinaController extends Controller
{

    protected $disciplinaService;

    public function __construct(LyDisciplinaService $disciplinaService)
    {
        $this->disciplinaService = $disciplinaService;
    }

    public function getMatriculas($aluno)
    {
        return $this->disciplinaService->getMatriculas($aluno);
    }


    public function getFormulaFromDisciplina($matriculas)
    {
        return $this->disciplinaService->getFormulaFromDisciplina($matriculas);
    }
}

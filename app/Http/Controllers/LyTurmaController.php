<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LySimuladorNotaFormulaService;
use App\Models\LyTurma;

class LyTurmaController extends Controller
{   
    protected $turmaService;

    public function __construct(LyTurmaService $turmaService)
    {
        $this->turmaService = $turmaService;
    }

    public function getFormulaFromTurma($disciplina, $ano)
    {
        return $this->turmaService->getFormulaFromTurma($disciplina, $ano);
    }
}

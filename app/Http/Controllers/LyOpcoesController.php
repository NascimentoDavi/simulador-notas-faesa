<?php

namespace App\Http\Controllers;

use App\Models\LyDisciplina;
use App\Models\LyMatricula;
use App\Services\LyDisciplinaService;
use App\Models\LyAluno;
use Illuminate\Http\Request;

class LyOpcoesController extends Controller
{
    protected $opcoesService;

    public function __construct(LyOpcoesService $opcoesService)
    {
        $this->opcoesService = $opcoesService;
    }

    public function getAnoSemestreAtual()
    {
        return $this->opcoesService->getAnoSemestreAtual();
    }

}
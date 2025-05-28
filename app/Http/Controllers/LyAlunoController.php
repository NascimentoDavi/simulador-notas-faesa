<?php

namespace App\Http\Controllers;

use App\Models\LyAluno;
use App\Models\LyCurso;
use App\Services\LyAlunoService;
use Illuminate\Http\Request;

class LyAlunoController extends Controller
{
    protected $alunoService;

    public function __construct(LyAlunoService $alunoService)
    {
        $this->alunoService = $alunoService;
    }

    public function getAluno($pessoa)
    {
       return $this->alunoService->getAluno($pessoa);
    }

    public function getCursoFromAluno($aluno)
    {
        return $this->alunoService->getCursoFromAluno($aluno);
    }

    public function getNotaAnoSemestreFromAluno(Request $request)
    {
        $aluno = session('aluno');
        $ano = $request->ano;
        $semestre = $request->semestre;

        $notas = $this->alunoService->getNotaAnoSemestreFromAluno($aluno, $ano, $semestre);
        
        return response()->json($notas); 
    }
}
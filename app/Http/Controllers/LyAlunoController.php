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

    // GET ALUNO
    public function getAluno($pessoa)
    {
       return $this->alunoService->getAluno($pessoa);
    }

    // GET CURSO FROM ALUNO
    public function getCursoFromAluno($aluno)
    {
        return $this->alunoService->getCursoFromAluno($aluno);
    }

    // RETORNA NOTAS POR ANO E SEMESTRE
    public function getNotaAnoSemestreFromAluno(Request $request)
    {
        $aluno = session('aluno');
        $ano = $request->ano;
        $semestre = $request->semestre;

        $notas = $this->alunoService->getNotaAnoSemestreFromAluno($aluno, $ano, $semestre);
        
        return response()->json($notas); 
    }

    // VERIFICA SE DISCIPLINAS SAO DO SEMESTRE ATUAL
    public function verificarDisciplinas (Request $request)
    {
        $disciplinas = $request->disciplinas;
        return $this->alunoService->verificarDisciplinas($disciplinas);
    }
}
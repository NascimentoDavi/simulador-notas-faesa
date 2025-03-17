<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ValidationController;
use App\Http\Controllers\LyDisciplinaController;
use App\Http\Controllers\LyAlunoController;
use App\Models\LyPessoa;
use App\Models\LyAluno;
use App\Models\LyNota;
use App\Models\LyCurso;
use App\Models\LyDisciplina;
use App\Models\LyMatricula;
use Illuminate\Support\Facades\View;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        // PESSOA
        $pessoaController = app(LyPessoaController::class);
        $pessoa = $pessoaController->getPessoa($request->input('login'));
        // ALUNO
        $alunoController = app(LyAlunoController::class);
        $aluno = $alunoController->getAluno($pessoa);

        // MATRICULAS
        $disciplinaController = app(LyDisciplinaController::class);
        $matriculas = $disciplinaController->getMatriculas($aluno);

        $disciplinas = $matriculas->pluck('DISCIPLINA');
        $anos = $matriculas->pluck('ANO')->unique()->sort()->values();
        $semestres = $matriculas->pluck('SEMESTRE')->unique()->sort()->values();
        /*dd($disciplinas,$anos,$semestres);*/

        $disciplinaController = app(LyDisciplinaController::class);
        $notas = $disciplinaController->getNota($aluno);

        /*dd($notas);*/

        if ($matriculas->isEmpty()) {
            return response()->view('error', [], 400);
        }

        // FORMULA
        $formula = $disciplinaController->getFormulaFromDisciplina($matriculas);

        $anoAtual = date('Y');
        $mesAtual = date('M');
        $semestreAtual = ($mesAtual <= 6) ? '1' : '2';

        // GET CURSO
        $curso = $alunoController->getCursoFromAluno($aluno);

        session([
            'aluno' => $aluno,
            'disciplinas' => $disciplinas,
            'anos' => $anos,
            'notas' => $notas,
            'semestres' => $semestres,
            'curso' => $curso,
            'formula_mp' => substr($formula->FORMULA_MF1, 0, 15),
            'formula_field' => substr($formula->FL_FIELD_01, 0, 30),
        ]);

        return redirect()->intended('/menu');
    }

    public function logout(Request $request)
    {
        return redirect()->route('beginning');
    }
}

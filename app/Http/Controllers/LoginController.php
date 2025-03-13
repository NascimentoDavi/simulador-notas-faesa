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

        // GET NOTAS
        $notaController = app(LyNotaController::class);
        $notasPivot = $notaController->getNotasPivot($aluno, $anoAtual, $semestreAtual);

        session([
            'notasPivot' => $notasPivot,
            'aluno' => $aluno,
            'curso' => $curso,
            'formula_nm' => substr($formula->FORMULA_MF2, 1, 18),
            'formula_mp' => substr($formula->FORMULA_MF1, 0, 15),
        ]);

        return redirect()->intended('/menu');
    }

    public function logout(Request $request)
    {
        return redirect()->route('beginning');
    }
}
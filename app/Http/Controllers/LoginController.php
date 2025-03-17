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
use App\Services\LyAlunoService;
use App\Services\LyPessoaService;
use App\Services\LyDisciplinaService;
use App\Services\LoginService;
use Illuminate\Support\Facades\View;

class LoginController extends Controller
{
    protected $loginService;

    /**
     * Construtor do AuthController.
     *
     * @param LoginService $loginService
     */
    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    /**
     * Realiza o login do usuário.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $login = $request->input('login');
        
        $loginResult = $this->loginService->realizarLogin($login);
        
        if (isset($loginResult['error'])) {
            return response()->view('error', ['message' => $loginResult['error']], 400);
        }

        // Cria a sessão com os dados do login
        session([
            'aluno' => $loginResult['aluno'],
            'curso' => $loginResult['curso'],
            'formula_nm' => substr($loginResult['formula']->FORMULA_MF2, 1, 18),
            'formula_mp' => substr($loginResult['formula']->FORMULA_MF1, 0, 15),
        ]);

        return redirect()->intended('/menu');
    }
}
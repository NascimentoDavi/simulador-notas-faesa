<?php

namespace App\Http\Controllers;

use App\Services\LyLoginService;
use App\DTOs\LoginDataDTO;
use Illuminate\Http\Request;

class LyLoginController extends Controller
{
    protected $loginService;

    public function __construct(LyLoginService $loginService)
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
        // Pega os dados da Request
        $login = $request->input('login');

        // Objeto Login
        $loginDataDTO = $this->loginService->realizarLogin($login);

        if (!$loginDataDTO) {
            return response()->view('error',['message' => 'Erro no login'], 400);
        } else {
            session([
                'aluno'       => $loginDataDTO->       aluno,
                'disciplinas' => $loginDataDTO->       disciplinas,
                'anos'        => $loginDataDTO->       anos,
                'notas'       => $loginDataDTO->       notas,
                'semestres'   => $loginDataDTO->       semestres,
                'curso'       => $loginDataDTO->       curso,
            ]);
            return redirect()->intended('/menu');
        }
    }

    public function logout()
    {
        session()->flush();
        return redirect()->intended('/login');
    }
}

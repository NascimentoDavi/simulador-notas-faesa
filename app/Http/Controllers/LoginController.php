<?php

namespace App\Http\Controllers;

use App\Services\LoginService;
use App\DTOs\LoginDataDTO;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $loginService;

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
        
        // Chama o LoginService para realizar o login
        $loginDataDTO = $this->loginService->realizarLogin($login);

        // Verifica se o DTO é nulo, o que indica erro
        if (!$loginDataDTO) {
            return response()->view('error', ['message' => 'Erro no login'], 400);
        }

        // Cria a sessão com os dados do login a partir do DTO
        session([
            'aluno' => $loginDataDTO->aluno,
            'curso' => $loginDataDTO->curso,
            'notas' => $loginDataDTO->notas,
            'formula_nm' => substr($loginDataDTO->formula->FORMULA_MF2, 1, 18),
            'formula_mp' => substr($loginDataDTO->formula->FORMULA_MF1, 0, 15),
        ]);

    return redirect()->intended('/menu');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->intended('/login');
    }
}

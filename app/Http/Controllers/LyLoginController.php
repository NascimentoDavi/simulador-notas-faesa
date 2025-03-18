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
        $login = $request->input('login');        
        $loginDataDTO = $this->loginService->realizarLogin($login);

        if (!$loginDataDTO) {
            return response()->view('error', ['message' => 'Erro no login'], 400);
        }

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

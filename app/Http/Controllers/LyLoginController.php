<?php


namespace App\Http\Controllers;


use App\Services\LyLoginService;
use App\DTOs\LoginDataDTO;
use Illuminate\Http\Request;


class LyLoginController extends Controller
{
    // Injeção de Dependência via Construtor
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
        $usuario = $request->input('login');

        // DTO - Cria Objeto Login
        $loginDataDTO = $this->loginService->realizarLogin($usuario);

        // Caso não ache os dados de matrícula, retorna mensagem de erro 'Matrícula não encontrada'
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
                'anosSemestresCursados' => $loginDataDTO-> anosSemestresCursados
            ]);
            return redirect()->intended('/menu');   
        }
    }


    // Funcao de deslogar - apaga dados da sessao do Usuario
    public function logout()
    {
        // Remove todos os dados da Sessão - Desloga
        session()->flush();

        // Redireciona para a tela de login
        return redirect()->intended('/login');
    }
}

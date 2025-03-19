<?php

namespace App\Services;

use App\DTOs\LoginDataDTO;
use App\Services\LyAlunoService;
use App\Services\LyPessoaService;
use App\Services\LyDisciplinaService;

class LyLoginService
{
    protected $alunoService;
    protected $pessoaService;
    protected $disciplinaService;

    /**
     * Construtor do LyLoginService.
     *
     * @param LyAlunoService $alunoService
     * @param LyPessoaService $pessoaService
     * @param LyDisciplinaService $disciplinaService
     */
    public function __construct(LyAlunoService $alunoService, LyPessoaService $pessoaService, LyDisciplinaService $disciplinaService)
    {
        $this->alunoService = $alunoService;
        $this->pessoaService = $pessoaService;
        $this->disciplinaService = $disciplinaService;
    }

    /**
     * Realiza o login do usuário.
     *
     * @param string $login
     * @return array
     */
    public function realizarLogin($login)
    {
        $pessoa = $this->pessoaService->getPessoa($login);
        if (!$pessoa) {
            return null;
        }

        $aluno = $this->alunoService->getAluno($pessoa);
        if (!$aluno) {
            return null;
        }

        $matriculas = $this->disciplinaService->getMatriculas($aluno);
        if ($matriculas->isEmpty()) {
            return null;
        }

        $notas = $this->disciplinaService->getNotas($aluno);

        $formula = $this->disciplinaService->getFormulaFromDisciplina($matriculas);
        $curso = $this->alunoService->getCursoFromAluno($aluno);

        // Retorna os dados encapsulados em um DTO - Data Transfer Objec
        return LoginDataDTO::create($aluno, $curso, $formula, $notas, );
    }
}

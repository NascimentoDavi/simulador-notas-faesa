<?php

namespace App\Services;

use App\Services\LyAlunoService;
use App\Services\LyPessoaService;
use App\Services\LyDisciplinaService;

class LoginService
{
    protected $alunoService;
    protected $pessoaService;
    protected $disciplinaService;

    /**
     * Construtor do LoginService.
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
            return ['error' => 'Pessoa não encontrada'];
        }

        $aluno = $this->alunoService->getAluno($pessoa);
        if (!$aluno) {
            return ['error' => 'Aluno não encontrado'];
        }

        $matriculas = $this->disciplinaService->getMatriculas($aluno);
        if ($matriculas->isEmpty()) {
            return ['error' => 'Nenhuma matrícula encontrada'];
        }

        $formula = $this->disciplinaService->getFormulaFromDisciplina($matriculas);
        
        $curso = $this->alunoService->getCursoFromAluno($aluno);

        return [
            'aluno' => $aluno,
            'curso' => $curso,
            'formula' => $formula,
        ];
    }
}

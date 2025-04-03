<?php

namespace App\Services;

use App\Models\LyDisciplina;

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
        // PESSOA
        $pessoa = $this->pessoaService->getPessoa($login);
        if (!$pessoa) {
            return null;
        }

        // ALUNO
        $aluno = $this->alunoService->getAluno($pessoa);
        if (!$aluno) {
            return null;
        }

        // Adicionar condicional para que alunos de pós não acessem. Mensagem de "Matrícula não encontrada" deve ser informada".

        // MATRICULA
        $matriculas = $this->disciplinaService->getMatriculas($aluno);
        if ($matriculas->isEmpty()) {
            return null;
        }

        // DISCIPLINA
        $disciplinas = $this->disciplinaService->getDisciplinas($matriculas);

        // ANO E SEMESTRE
        $anos = $matriculas->pluck('ANO')->unique()->sort()->values();
        $semestres = $matriculas->pluck('SEMESTRE')->unique()->sort()->values();

        // NOTAS
        $notas = $this->disciplinaService->getNotas($aluno, $matriculas, $disciplinas);

        // CURSO
        $curso = $this->alunoService->getCursoFromAluno($aluno);

        // Retorna os Dados encapsulados em DTO - Data Transfer Object
        return LoginDataDTO::create(
            $aluno,
            $disciplinas,
            $anos,
            $notas,
            $semestres,
            $curso,
            $notas
        );
    }
}

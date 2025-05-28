<?php


namespace App\Services;


use App\Models\LyDisciplina;
use App\DTOs\LoginDataDTO;
use App\Services\LyAlunoService;
use App\Services\LyPessoaService;
use App\Services\LyDisciplinaService;
use App\Services\LyOpcoesService;


class LyLoginService
{

    protected $alunoService;
    protected $pessoaService;
    protected $disciplinaService;
    protected $opcoesService;
    /**
     * Construtor do LyLoginService.
     *
     * @param LyAlunoService $alunoService
     * @param LyPessoaService $pessoaService
     * @param LyDisciplinaService $disciplinaService
     * @param LyOpcoesService $opcoesService
     */
    public function __construct(LyAlunoService $alunoService, 
                                LyPessoaService $pessoaService,
                                LyDisciplinaService $disciplinaService,
                                LyOpcoesService $opcoesService)
    {
        $this->alunoService = $alunoService;
        $this->pessoaService = $pessoaService;
        $this->disciplinaService = $disciplinaService;
        $this->opcoesService = $opcoesService;
    }


    /**
     * Realiza o login do usuário.
     *
     * @param string $usuario
     * @return array
     */
    public function realizarLogin($usuario)
    {
        
        // ANO SEMESTRE ATUAIS
        $anoSemestre = $this->opcoesService->getAnoSemestreAtual();


        // PESSOA
        $pessoa = $this->pessoaService->getPessoa($usuario);
        if (!$pessoa) {
            return null;
        }


        // ALUNO
        $aluno = $this->alunoService->getAluno($pessoa);
        if (!$aluno) {
            return null;
        }

        // ANOS E SEMESTRES JA CURSADOS
        $anosSemestresCursados = $this->alunoService->getAnosSemestresCursados($aluno);
        $anosCursados = array_unique(array_column($anosSemestresCursados, 'ano'));
        $semestresCursados = array_unique(array_column($anosSemestresCursados, 'semestre'));

        
        // MATRICULA
        $matriculas = $this->disciplinaService->getMatriculas($aluno, $anoSemestre[0], $anoSemestre[1]);
        if ($matriculas->isEmpty()) {
            return null;
        }
        

        // DISCIPLINA
        $disciplinas = $this->disciplinaService->getDisciplinas($matriculas);

        
        // NOTAS
        $notas = $this->disciplinaService->getNotas($aluno, $anoSemestre[0], $anoSemestre[1], $disciplinas);

        
        // CURSO
        $curso = $this->alunoService->getCursoFromAluno($aluno, $anoSemestre[0], $anoSemestre[1]);

        
        // DTO
        return LoginDataDTO::create(
            $aluno,
            $disciplinas,
            $anoSemestre[0],
            $notas,
            $anoSemestre[1],
            $curso,
            $anosCursados,
            $semestresCursados
        );
    }
}

<?php

namespace App\DTOs;

class LoginDataDTO
{
    public $aluno;
    public $curso;
    public $formula;
    public $notas;

    /**
     * Construtor
     *
     * @param $aluno
     * @param $curso
     * @param $formula
     * @param $notas
     */
    public function __construct($aluno, $curso, $formula, $notas)
    {
        $this->aluno = $aluno;
        $this->curso = $curso;
        $this->formula = $formula;
        $this->notas = $notas;
    }

    /**
     * Criar um DTO a partir dos dados retornados.
     *
     * @param $aluno
     * @param $curso
     * @param $formula
     * @param $notas
     * @return LoginDataDTO
     */
    public static function create($aluno, $curso, $formula, $notas)
    {
        return new self($aluno, $curso, $formula, $notas);
    }
}

<?php

namespace App\DTOs;

class LoginDataDTO
{
    public $aluno;
    public $disciplinas;
    public $anos;
    public $notas;
    public $semestres;
    public $curso;
    public $formula;

    /**
     * Construtor
     *
     * @param $aluno
     * @param $disciplinas
     * @param $anos
     * @param $notas
     * @param $semestres
     * @param $curso
     * @param $formula
     */
    public function __construct($aluno, $disciplinas, $anos, $notas, $semestres, $curso, $formula)
    {
        $this->aluno = $aluno;
        $this->disciplinas = $disciplinas;
        $this->anos = $anos;
        $this->notas = $notas;
        $this->semestres = $semestres;
        $this->curso = $curso;
        $this->formula = $formula;
        $this->notas = $notas;
    }

    /**
     * Criar um DTO a partir dos dados retornados.
     *
     * @param $aluno
     * @param $disciplinas
     * @param $anos
     * @param $notas
     * @param $semestres
     * @param $curso
     * @param $formula
     * @return LoginDataDTO
     */
    public static function create($aluno, $disciplinas, $anos, $notas, $semestres, $curso, $formula)
    {
        return new self($aluno, $disciplinas, $anos, $notas, $semestres, $curso, $formula);
    }
}

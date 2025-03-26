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

    /**
     * Construtor
     *
     * @param $aluno
     * @param $disciplinas
     * @param $anos
     * @param $notas
     * @param $semestres
     * @param $curso
     */
    public function __construct($aluno, $disciplinas, $anos, $notas, $semestres, $curso)
    {
        $this->aluno = $aluno;
        $this->disciplinas = $disciplinas;
        $this->anos = $anos;
        $this->notas = $notas;
        $this->semestres = $semestres;
        $this->curso = $curso;
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
     * @return LoginDataDTO
     */
    public static function create($aluno, $disciplinas, $anos, $notas, $semestres, $curso)
    {
        return new self($aluno, $disciplinas, $anos, $notas, $semestres, $curso);
    }
}

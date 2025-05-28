<?php

namespace App\DTOs;

class LoginDataDTO
{
    // Propriedades do Objeto
    public $aluno;
    public $disciplinas;
    public $anos;
    public $notas;
    public $semestres;
    public $curso;
    public $anosCursados;
    public $semestresCursados;

    /**
     * Construtor
     *
     * @param $aluno
     * @param $disciplinas
     * @param $anos
     * @param $notas
     * @param $semestres
     * @param $curso
     * @param $anosCursados
     * @param $semestresCursados
     */
    public function __construct($aluno, $disciplinas, $anos, $notas, $semestres, $curso, $anosCursados, $semestresCursados)
    {
        $this->aluno = $aluno;
        $this->disciplinas = $disciplinas;
        $this->anos = $anos;
        $this->notas = $notas;
        $this->semestres = $semestres;
        $this->curso = $curso;
        $this->notas = $notas;
        $this->anosCursados = $anosCursados;
        $this->semestresCursados = $semestresCursados;
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
     * @param $anosCursados
     * @param $semestresCursados
     * @return LoginDataDTO
     */
    public static function create($aluno, $disciplinas, $anos, $notas, $semestres, $curso, $anosCursados, $semestresCursados)
    {
        return new self($aluno, $disciplinas, $anos, $notas, $semestres, $curso, $anosCursados, $semestresCursados);
    }
}

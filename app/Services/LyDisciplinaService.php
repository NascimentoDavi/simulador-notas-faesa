<?php

namespace App\Services;

use App\Models\LyMatricula;
use App\Models\LyDisciplina;
use App\Models\LyAluno;
use App\Models\LyNota;

class LyDisciplinaService
{
    /**
     * Obtém as matrículas de um aluno.
     *
     * @param array $aluno Dados do aluno para buscar as matrículas.
     * @return \Illuminate\Database\Eloquent\Collection Coleção de matrículas do aluno.
     */
    public function getMatriculas($aluno)
    {
        return LyMatricula::where('ALUNO', '=', $aluno['ALUNO'])->get('DISCIPLINA');
    }

    /**
     * Obtém a fórmula de cálculo da disciplina com base nas matrículas do aluno.
     *
     * @param \Illuminate\Database\Eloquent\Collection $matriculas Coleção de matrículas do aluno.
     * @return mixed Retorna a fórmula ou null caso a matrícula esteja vazia.
     */
    public function getFormulaFromDisciplina($matriculas)
    {
        if($matriculas->isEmpty()){
            return null;
        }

        return LyDisciplina::where('DISCIPLINA', '=', $matriculas[0]->DISCIPLINA)
            ->first(['FORMULA_MF1', 'FORMULA_MF2']);
    }

    /**
     * Obtém as notas do aluno, agrupando por disciplina.
     *
     * @param array $aluno Dados do aluno para buscar as notas.
     * @return \Illuminate\Support\Collection Coleção de notas organizadas por disciplina.
     */
    public function getNotas($aluno)
    {
        $matriculas = $this->getMatriculas($aluno);

        // Vamos buscar as disciplinas que o aluno está matriculado
        $disciplinas = LyDisciplina::whereIn('DISCIPLINA', $matriculas->pluck('DISCIPLINA'))->get();

        // Agora, busque as notas do aluno para essas disciplinas
        $notas = LyNota::join('ly_disciplina', 'LY_NOTA.DISCIPLINA', '=', 'ly_disciplina.DISCIPLINA')
            ->select(
                'LY_NOTA.DISCIPLINA',
                'LY_NOTA.PROVA',
                'LY_NOTA.CONCEITO',
                'LY_DISCIPLINA.NOME AS NOME_DISCIPLINA'
            )
            ->where('LY_NOTA.ALUNO', $aluno['ALUNO'])
            ->where('LY_NOTA.ANO', $matriculas->pluck('ANO'))
            ->where('LY_NOTA.SEMESTRE', $matriculas->pluck('SEMESTRE'))
            ->whereIn('LY_NOTA.PROVA', ['C1', 'C2', 'C3'])
            ->get()
            ->groupBy('DISCIPLINA');

        // Vamos agora garantir que mesmo que não existam notas para a disciplina, ela será exibida com nome e notas vazias.
        $notasOrganizadas = $disciplinas->map(function ($disciplina) use ($notas) {
            // Obter as notas para a disciplina ou definir valores padrão
            $notasDisciplina = $notas->get($disciplina->DISCIPLINA, collect());

            return [
                'DISCIPLINA' => $disciplina->DISCIPLINA,
                'NOME_DISCIPLINA' => $disciplina->NOME,
                'C1' => $notasDisciplina->where('PROVA', 'C1')->first()->CONCEITO ?? '-',
                'C2' => $notasDisciplina->where('PROVA', 'C2')->first()->CONCEITO ?? '-',
                'C3' => $notasDisciplina->where('PROVA', 'C3')->first()->CONCEITO ?? '-',
            ];
        });

        return $notasOrganizadas;
    }

    /**
     * Obtém as notas de um aluno para um ano e semestre específicos.
     * Este método está parcialmente implementado, com a lógica de acesso à base de dados ainda incompleta.
     *
     * @param array $aluno Dados do aluno para buscar as notas.
     * @param string $ano O ano para filtrar as notas.
     * @param string $semestre O semestre para filtrar as notas.
     * @return array Array com as notas filtradas por ano e semestre.
     */
    public function getNotasAnoSemestre($aluno, $ano, $semestre)
    {
        $matriculas = $this->getMatriculas($aluno);        
        $notas = [];
        return $notas;
    }
}

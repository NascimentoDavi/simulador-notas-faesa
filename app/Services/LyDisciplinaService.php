<?php

namespace App\Services;

use App\Models\LyMatricula;
use App\Models\LyDisciplina;
use App\Models\LyAluno;
use App\Models\LyNota;
use App\Models\LyNotaHistMatr;

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

        $notas = LyNotaHistMatr::join('ly_disciplina', 'ly_nota_histmatr.DISCIPLINA', '=', 'ly_disciplina.DISCIPLINA')
            ->select(
                'LY_NOTA_HISTMATR.DISCIPLINA',
                'LY_NOTA_HISTMATR.NOTA_ID',
                'LY_NOTA_HISTMATR.CONCEITO',
                'LY_DISCIPLINA.NOME AS NOME_DISCIPLINA'
            )
            ->where('ly_nota_histmatr.ALUNO', $aluno['ALUNO'])
            ->where('ly_nota_histmatr.ANO', '2024')
            ->where('ly_nota_histmatr.SEMESTRE', '1')
            ->whereIn('ly_nota_histmatr.NOTA_ID', ['C1', 'C2', 'C3'])
            ->get()
            ->groupBy('DISCIPLINA');

        $notasOrganizadas = $notas->map(function ($group) {
            $groupedData = [
                'DISCIPLINA' => $group->first()->DISCIPLINA,
                'NOME_DISCIPLINA' => $group->first()->NOME_DISCIPLINA,
                'C1' => $group->where('NOTA_ID', 'C1')->first()->CONCEITO ?? 'NI',
                'C2' => $group->where('NOTA_ID', 'C2')->first()->CONCEITO ?? 'NI',
                'C3' => $group->where('NOTA_ID', 'C3')->first()->CONCEITO ?? 'NI',
            ];
            return $groupedData;
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

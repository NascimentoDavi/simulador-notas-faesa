<?php

namespace App\Services;

use App\Models\LyMatricula;
use App\Models\LyDisciplina;
use App\Models\LyAluno;
use App\Models\LyNota;
use App\Models\LyNotaHistMatr;

class LyDisciplinaService
{

    public function getDisciplinas($matriculas)
    {
        $disciplinas = LyDisciplina::whereIn('DISCIPLINA', $matriculas->pluck('DISCIPLINA'))->get();
        return $disciplinas;
    }

    /**
     * Obtém as matrículas de um aluno.
     *
     * @param array $aluno Dados do aluno para buscar as matrículas.
     * @return \Illuminate\Database\Eloquent\Collection Coleção de matrículas do aluno.
     */
    public function getMatriculas($aluno, $ano, $semestre)
    {
        return LyMatricula::where('ALUNO', '=', $aluno['ALUNO'])
                          ->where('ANO', $ano)
                          ->where('SEMESTRE',  $semestre)
        ->get(['DISCIPLINA', 'ANO', 'SEMESTRE']);
    }

    /**
     * Obtém as notas do aluno, agrupando por disciplina.
     *
     * @param array $aluno Dados do aluno para buscar as notas.
     * @return \Illuminate\Support\Collection Coleção de notas organizadas por disciplina.
     */
    public function getNotas($aluno, $ano, $semestre, $disciplinas)
    {
        $notas = LyNota::join('LY_DISCIPLINA', 'LY_NOTA.DISCIPLINA', '=', 'LY_DISCIPLINA.DISCIPLINA')
            ->select(
                'LY_NOTA.DISCIPLINA',
                'LY_NOTA.PROVA',
                'LY_NOTA.CONCEITO',
                'LY_DISCIPLINA.NOME AS NOME_DISCIPLINA'
            )
            ->where('LY_NOTA.ALUNO', $aluno['ALUNO'])
            ->where('LY_NOTA.ANO', $ano)
            ->where('LY_NOTA.SEMESTRE', $semestre)
            ->whereIn('LY_NOTA.PROVA', ['C1', 'C2', 'C3'])
            ->get()
            ->groupBy('DISCIPLINA');

        $notasOrganizadas = $disciplinas->map(function ($disciplina) use ($notas) {
            $notasDisciplina = $notas->get($disciplina->DISCIPLINA, collect());

            return [
                'DISCIPLINA' => $disciplina->DISCIPLINA,
                'NOME_DISCIPLINA' => $disciplina->NOME,
                'C1' => $notasDisciplina->where('PROVA', 'C1')->first()->CONCEITO ?? 0,
                'C2' => $notasDisciplina->where('PROVA', 'C2')->first()->CONCEITO ?? 0,
                'C3' => $notasDisciplina->where('PROVA', 'C3')->first()->CONCEITO ?? 0
            ];
        });
        return $notasOrganizadas;
    }
}
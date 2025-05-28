<?php

namespace App\Services;

use App\Models\LyAluno;
use App\Models\LyNota;
use App\Models\LyCurso;
use App\Models\LyNotaHistMatr;

class LyAlunoService
{
    /**
     * Retorna o aluno a partir da pessoa
     */
    public function getAluno($pessoa)
    {

        // Caso o aluo tenha mais de uma matrícula, pega a mais recente
        // In case the student has more than one enrollment, it captures the most recent one

        return LyAluno::where('NOME_COMPL', '=', $pessoa->NOME_COMPL)
        ->latest('DT_INGRESSO')
        ->first();
    }

    /**
     * Retorna o curso de um aluno
     */
    public function getCursoFromAluno($aluno)
    {
        return LyCurso::where('CURSO', '=', $aluno->CURSO)->first();
    }


    // Retornas as notas de acordo com Ano e Semestre informados
    public function getNotaAnoSemestreFromAluno($aluno, $ano, $semestre)
        {
            // Caso ano e semestre solicitados sejam ano e semestre atuais
            if ($ano === session('anos') && $semestre === session('semestres')) {

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

                $notasOrganizadas = [];

                foreach ($notas as $disciplina => $notasDisciplina) {
                    $notasOrganizadas[] = [
                        'DISCIPLINA' => $disciplina,
                        'NOME_DISCIPLINA' => $notasDisciplina->first()->NOME_DISCIPLINA ?? 'Desconhecida',
                        'C1' => optional($notasDisciplina->where('PROVA', 'C1')->first())->CONCEITO ?? 0,
                        'C2' => optional($notasDisciplina->where('PROVA', 'C2')->first())->CONCEITO ?? 0,
                        'C3' => optional($notasDisciplina->where('PROVA', 'C3')->first())->CONCEITO ?? 0
                    ];
                }
                // dd($notasOrganizadas);
                return $notasOrganizadas;
            }

            // Caso session('anos') não exista, usar a tabela histórica
            $notas = LyNotaHistMatr::join('LY_DISCIPLINA', 'LY_NOTA_HISTMATR.DISCIPLINA', '=', 'LY_DISCIPLINA.DISCIPLINA')
                ->select(
                    'LY_NOTA_HISTMATR.DISCIPLINA',
                    'LY_NOTA_HISTMATR.NOTA_ID',
                    'LY_NOTA_HISTMATR.CONCEITO',
                    'LY_DISCIPLINA.NOME AS NOME_DISCIPLINA'
                )
                ->where('LY_NOTA_HISTMATR.ALUNO', $aluno['ALUNO'])
                ->where('LY_NOTA_HISTMATR.ANO', $ano)
                ->where('LY_NOTA_HISTMATR.SEMESTRE', $semestre)
                ->whereIn('LY_NOTA_HISTMATR.NOTA_ID', ['C1', 'C2', 'C3'])
                ->get()
                ->groupBy('DISCIPLINA');

            $notasOrganizadas = [];

            foreach ($notas as $disciplina => $notasDisciplina) {
                $notasOrganizadas[] = [
                    'DISCIPLINA' => $disciplina,
                    'NOME_DISCIPLINA' => $notasDisciplina->first()->NOME_DISCIPLINA ?? 'Desconhecida',
                    'C1' => optional($notasDisciplina->where('NOTA_ID', 'C1')->first())->CONCEITO ?? 'NI',
                    'C2' => optional($notasDisciplina->where('NOTA_ID', 'C2')->first())->CONCEITO ?? 'NI',
                    'C3' => optional($notasDisciplina->where('NOTA_ID', 'C3')->first())->CONCEITO ?? 'NI',
                ];
            }

            return $notasOrganizadas;
        }

    public function getAnosSemestresCursados($aluno)
    {
        $anosSemestresCursados = LyNotaHistMatr::where('ALUNO', '=', $aluno['ALUNO'])
        ->select('ano', 'semestre')
        ->distinct()
        ->get()
        ->toArray();

        return $anosSemestresCursados;
    }
}
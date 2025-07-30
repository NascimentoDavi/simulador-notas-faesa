<?php

namespace App\Services;

use App\Models\LyAluno;
use App\Models\LyNota;
use App\Models\LyCurso;
use App\Models\LyNotaHistMatr;
use App\Models\LyMatricula;

class LyAlunoService
{
    /**
     * Retorna o aluno a partir da pessoa
     */
    public function getAluno($pessoa)
    {
        // Caso o aluno tenha mais de uma matrícula, pega a mais recente
        return LyAluno::where('NOME_COMPL', '=', $pessoa->NOME_COMPL)
        ->latest('DT_INGRESSO')
        ->where('SIT_ALUNO', '=', 'Ativo')
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
        $disciplinas = session('disciplinas');

        // Caso ano e semestre solicitados sejam ano e semestre atuais
        if ($ano == session('anos') && $semestre == session('semestres')) {

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
                'C1' => optional($notasDisciplina->where('NOTA_ID', 'C1')->first())->CONCEITO ?? 0,
                'C2' => optional($notasDisciplina->where('NOTA_ID', 'C2')->first())->CONCEITO ?? 0,
                'C3' => optional($notasDisciplina->where('NOTA_ID', 'C3')->first())->CONCEITO ?? 0,
            ];
        }
        return $notasOrganizadas;
    }

    // RETORNA ANOS E SEMESTRES CURSADOS
    public function getAnosSemestresCursados($aluno)
    {
        // ANO / SEMESTRES PASSADOS
        $anosSemestresCursados = LyNotaHistMatr::where('ALUNO', '=', $aluno['ALUNO'])
        ->select('ano', 'semestre')
        ->distinct()
        ->get();

        // ANO / SEMESTRE ATUAIS
        $anoSemestreAtuais = LyMatricula::where('ALUNO', '=', $aluno['ALUNO'])
        ->select('ano', 'semestre')
        ->distinct()
        ->get();

        $agrupados = [];

        foreach ($anosSemestresCursados as $registro) {
            $ano = $registro->ano;
            $semestre = $registro->semestre;

            if (!isset($agrupados[$ano])) {
                $agrupados[$ano] = [];
            }

            // Se ainda não adicionou este semestre para este ano, adiciona
            if (!in_array($semestre, $agrupados[$ano])) {
                $agrupados[$ano][] = $semestre;
            }
        }

        foreach ($anoSemestreAtuais as $registro) {
            $ano = $registro->ano;
            $semestre = $registro->semestre;

            if (!isset($agrupados[$ano])) {
                $agrupados[$ano] = [];
            }

            // Se ainda não adicionou este semestre para este ano, adiciona
            if (!in_array($semestre, $agrupados[$ano])) {
                $agrupados[$ano][] = $semestre;
            }
        }
        return $agrupados;
    }

    // VERIFICA SE DISCIPLINAS CORRESPONDEM A SEMESTRE ATUAL
    // MODIFICAÇÃO PARA ADERIR TURMAS DE MEDICINA - FIXAR APÓS PARA ADERIR DEMAIS
    public function verificarDisciplinas($disciplina)
    {
        $aluno = session('aluno')->ALUNO;

        $registros = LyMatricula::where('ALUNO', '=', $aluno)
        ->where('DISCIPLINA', '=', $disciplina[0])
        ->get();

        if($registros->isEmpty()) {
            return 0;
        }
        return 1;
    }
    
}
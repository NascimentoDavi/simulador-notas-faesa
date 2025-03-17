<?php

namespace App\Http\Controllers;

use App\Models\LyDisciplina;
use App\Models\LyMatricula;
use App\Models\LyAluno;
use App\Models\LyNota;
use App\Models\LyNotaHistMatr;
use Illuminate\Http\Request;

class LyDisciplinaController extends Controller
{
    public function getMatriculas($aluno)
    {
        $matriculas = LyMatricula::where('ALUNO', '=', $aluno['ALUNO'])
            ->where('SIT_Matricula', '=', 'Matriculado') // Adicionando condição para filtrar apenas matriculados
            ->get(['DISCIPLINA', 'ANO', 'SEMESTRE']);

        return $matriculas;
    }

    public function getNota($aluno)
    {
        // Pega as matrículas do aluno
        $matriculas = $this->getMatriculas($aluno);

        // Inicializa um array para armazenar as notas
        $notas = [];

        // Para cada matrícula, pega as notas correspondentes
        foreach ($matriculas as $matricula) {
            // Pega as notas para a disciplina, ano e semestre do aluno
            $nota = LyNota::join('ly_matricula', 'ly_matricula.ALUNO', '=', 'ly_nota.ALUNO')
                ->where('ly_nota.DISCIPLINA', '=', $matricula->DISCIPLINA)
                ->where('ly_nota.ANO', '=', $matricula->ANO)
                ->where('ly_nota.SEMESTRE', '=', $matricula->SEMESTRE)
                ->where('ly_matricula.ALUNO', '=', $aluno['ALUNO']) // Só para o aluno logado
                ->where('ly_matricula.SIT_MATRICULA', '=', 'Matriculado') // Só notas de disciplinas com matrícula 'Matriculado'
                ->get(['ly_nota.CONCEITO']); // Retorna o conceito da nota

            // Adiciona as notas ao array
            $notas[] = [
                'DISCIPLINA' => $matricula->DISCIPLINA,
                'ANO' => $matricula->ANO,
                'SEMESTRE' => $matricula->SEMESTRE,
                'NOTA' => $nota
            ];
        }

        return $notas;
    }

    public function getNotaHistorico($aluno, $disciplina, $ano, $semestre)
    {
        $notahistorico = LyNotaHistMatr::where('ALUNO', '=', $aluno['ALUNO'])
            ->where('DISCIPLINA', '=', $disciplina)
            ->where('ANO', '=', $ano)
            ->where('SEMESTRE', '=', $semestre)
            ->get(['CONCEITO']);

        return $notahistorico;
    }

    public function getFormulaFromDisciplina($matriculas)
    {
        if ($matriculas->isEmpty()) {
            return null;
        }

        return LyDisciplina::where('DISCIPLINA', '=', $matriculas[1]->DISCIPLINA)
            ->first(['DISCIPLINA', 'FORMULA_MF1', 'FL_FIELD_01']);
    }
}

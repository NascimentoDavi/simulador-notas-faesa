<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LySimuladorNotaFormulaService;

class LySimuladorNotaFormulaController extends Controller
{   
    protected $simuladorNotaFormulaService;
    public function __construct(LySimuladorNotaFormulaService $simuladorNotaFormulaService)
    {
        $this->simuladorNotaFormulaService = $simuladorNotaFormulaService;
    }

    // REALIZA SIMULACAO
    public function simular(Request $request)
    {

    // Armazena os valores das notas nas variaveis através da request (valor enviado no formulario)
        $c1 = floatval($request->input('c1', 0));
        $c2 = floatval($request->input('c2', 0));
        $c3 = floatval($request->input('c3', 0));
        $ano = session('anos');
        $semestre = session('semestres');

        $result = $this->simuladorNotaFormulaService->simularNotas($c1, $c2, $c3, session('aluno')->ALUNO, $request->input('disciplina'), $ano, $semestre);

        return response()->json($result);
    }
}

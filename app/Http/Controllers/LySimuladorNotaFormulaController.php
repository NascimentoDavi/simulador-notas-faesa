<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LySimuladorNotaFormulaService;

class LySimuladorNotaFormulaController extends Controller
{   
    
    protected $simuladorNotaFormulaService;

    // Dependencie Injection
    public function __construct(LySimuladorNotaFormulaService $simuladorNotaFormulaService)
    {
        $this->simuladorNotaFormulaService = $simuladorNotaFormulaService;
    }

    public function simular(Request $request)
    {
        $c1 = floatval($request->input('c1', 0));
        $c2 = floatval($request->input('c2', 0));
        $c3 = floatval($request->input('c3', 0));

        $ano = date("Y");

        $result = $this->simuladorNotaFormulaService->simularNotas($c1, $c2, $c3, $request->input('disciplina'), $ano);

        return response()->json($result);
    }

}

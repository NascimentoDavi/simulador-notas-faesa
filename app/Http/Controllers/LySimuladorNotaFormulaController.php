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

        $result = $this->simuladorNotaFormulaService->simularNotas($c1, $c2, $c3);

        return response()->json($result);
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LySimuladorNotaFormulaController extends Controller
{   
    public function simular (Request $request)
    {
        $formula_mp = session('formula_mp');
        $formula_nm = session('formula_nm');

        $c1 = $request->input('c1', 0);
        $c2 = $request->input('c2', 0);
        $c3 = $request->input('c3', 0);

        $expressao_mp = str_replace(['C1', 'C2', 'C3'], [$c1, $c2, $c3], $formula_mp);
        $expressao_nm = str_replace(['C1', 'C2', 'C3'], [$c1, $c2, $c3], $formula_nm);

        try {
            $resultado_mp = eval("return $expressao_mp;");
            $resultado_nm = eval("return $expressao_nm;");
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Invalid Formula'], 400);
        }

        $mediaAritmetica = $resultado_mp;
        $mediaProvaFinal = ((5.02 - $resultado_nm) / 0.4);

        return response()->json([
            'mediaAritmetica' => $mediaAritmetica,
            'mediaProvaFinal' => $mediaProvaFinal,
        ]);
    }
}

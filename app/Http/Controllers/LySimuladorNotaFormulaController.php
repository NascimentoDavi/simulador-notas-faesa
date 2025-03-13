<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LySimuladorNotaFormulaController extends Controller
{   
    public function simular(Request $request)
    {
        $c1 = floatval($request->input('c1', 0));
        $c2 = floatval($request->input('c2', 0));
        $c3 = floatval($request->input('c3', 0));
    
        // Calculando a média das provas
        $mediaAritmetica = round(($c1 + $c2 + $c3) / 3, 2);
    
        // Cálculo da média da prova final
        $mediaProvaFinal = round((5 - ($mediaAritmetica * 0.6)) / 0.4, 2);

        $mediaProvaFinal = ceil($mediaProvaFinal * 20) / 20;
    
        return response()->json([
            'mediaAritmetica' => number_format($mediaAritmetica, 2, '.', ''),
            'mediaProvaFinal' => number_format($mediaProvaFinal, 2, '.', ''),
        ]);
    }    
    
}

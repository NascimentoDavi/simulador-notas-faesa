<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LySimuladorNotaFormulaController extends Controller
{   
    public function simular (Request $request)
    {
        $mp = 85;
        $nm = 92;

        return response()->json([
            'mp' => $mp,
            'nm' => $nm,
        ]);
    }
}

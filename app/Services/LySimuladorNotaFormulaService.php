<?php

namespace App\Services;

class SimuladorNotaFormulaService
{

    /**
     * Simula as notas e calcula as médias.
     *
     * @param float $c1 Nota da prova c1
     * @param float $c2 Nota da prova c2
     * @param float $c3 Nota da prova c3
     * @return array Retorna as médias formatadas
     */
    public function simularNotas($c1, $c2, $c3)
    {
        
        // Calculando a média das provas
        $mediaAritmetica = round(($c1 + $c2 + $c3) / 3, 2);
            
        // Cálculo da média da prova final
        $mediaProvaFinal = round((5 - ($mediaAritmetica * 0.6)) / 0.4, 2);

        // Ajustando a média da prova final
        $mediaProvaFinal = ceil($mediaProvaFinal * 20) / 20;
        
        return [
            'mediaAritmetica' => number_format($mediaAritmetica, 2, '.', ''),
            'mediaProvaFinal' => number_format($mediaProvaFinal, 2, '.', ''),
        ];
    }
}
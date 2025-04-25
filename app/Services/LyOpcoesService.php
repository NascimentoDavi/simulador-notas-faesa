<?php

namespace App\Services;

use App\Models\LyOpcoes;

class LyOpcoesService
{

    /**
     * Retorna o ano e o semestre letivo atual a partir das opções do sistema.
     *
     * @return array ['ano_letivo' => int|null, 'semestre_letivo' => int|null]
     */
    public function getAnoSemestreAtual()
    {
        // Consulta na Tabela
        $opcoes = LyOpcoes::where('CHAVE', '4')->first(['ANO_LETIVO', 'SEM_LETIVO']);

        // Armazena ANO e SEMESTRE nas variaveis abaixo
        $ano = $opcoes->ANO_LETIVO ?? null;
        $semestre = $opcoes->SEM_LETIVO ?? null;
        
        // Retorna ANO e SEMESTRE em formato de Array
        return [
            $ano,
            $semestre
        ];
    }

}
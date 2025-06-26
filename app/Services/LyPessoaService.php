<?php

namespace App\Services;

use App\Models\LyPessoa;

class LyPessoaService
{
    public function getPessoa($login)
    {
        $usuario_coluna  = config('ly_pessoa.faesa.usuario_coluna');
        $usuario_prefixo = config('ly_pessoa.faesa.usuario_prefixo');

        return LyPessoa::where('WINUSUARIO', '=', "FAESA\\{$login}")->first();
    }
}
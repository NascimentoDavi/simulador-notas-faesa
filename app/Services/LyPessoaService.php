<?php

namespace App\Services;

use App\Models\LyPessoa;

class LyPessoaService
{
    public function getPessoa($login)
    {
        return LyPessoa::where('WINUSUARIO', '=', "FAESA\\{$login}")->first();
    }
}
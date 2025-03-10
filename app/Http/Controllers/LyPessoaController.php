<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LyPessoa;

class LyPessoaController extends Controller
{
    public function getPessoa($login)
    {
        $pessoa = LyPessoa::where('WINUSUARIO', '=', "FAESA\\{$login}")->first();
        return $pessoa;
    }
}

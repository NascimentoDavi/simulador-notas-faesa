<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LyPessoa;
use App\Services\LyPessoaService;

class LyPessoaController extends Controller
{

    protected $pessoaService;

    public function __constructed(LyPessoaService $pessoaService)
    {
        $this->pessoaService = $pessoaService;
    }

    public function getPessoa($login)
    {
        return $this->pessoaService->getPessoa($login);
    }
}

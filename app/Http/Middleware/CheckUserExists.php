<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\LyPessoa;

class CheckUserExists
{

    public function handle(Request $request, Closure $next): Response
    {
        $login = $request->input('login');
        $pessoa = LyPessoa::where('WINUSUARIO', "=", "FAESA\\{$login}")->first();

        if(!$pessoa) {
            return redirect()->back()->withErrors(['login' => "Usuário não encontrado. Verifique suas credenciais"]);
        }

        // Now the request contains an additional parameter 'pessoa', with is value set to $pessoa.
        $request->merge(['pessoa' => $pessoa]);
        return $next($request);
    }
    
}

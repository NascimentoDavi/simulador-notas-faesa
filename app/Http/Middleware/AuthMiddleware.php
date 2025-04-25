<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Http;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {

        // Verifica se a rota é 'login' ou 'logout'. Caso positivo, deixa passar.
        if (in_array($request->route()->getName(), ['loginGET', 'logout'])) {
            return $next($request);
        }

        // Se Usuário tentou acessar sistema com usuario e senha
        if ($request->route()->getName() == 'loginPOST') {

            // Armazena Credenciais
            $credentials = [
                'username' => $request->input('login'),
                'password' => $request->input('senha'),
            ];

            // API DATA
            $response = $this->getApiData($credentials);

            // Se Autenticou, prox. rota
            if ($response['success']) {
                return $next($request);
            } else {
                return redirect()->back()->with('error', "Credenciais Inválidas");
            }
        }

        return $next($request);
    }


    // Funcao que chama API de autenticacao de usuario
    public function getApiData(array $credentials): array
    {

        // Dados da API (config/services.php)
        $apiUrl = config('services.faesa.api_url');
        $apiKey = env('FAESA_API_KEY');


        try {
            $response = Http::withHeaders([
                'Accept'        => "application/json",
                'Authorization' => $apiKey
            ])->timeout(5)
            ->post($apiUrl, $credentials);
            

            // SE RESPOSTA OK [STATUS 200] -> RETORNA TOKEN DE ACESSO (acess_token)
            if ($response->successful()) {
                return [
                    'success' => true,
                    'data'    => $response->json()
                ];
            }
            
            // SE RESPOSTA Bad Request [STATUS 400] -> Retorna 'unauthenticated'
            return [
                'success' => false,
                'message' => 'Credenciais Inválidas',
                'status'  => $response->status()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}

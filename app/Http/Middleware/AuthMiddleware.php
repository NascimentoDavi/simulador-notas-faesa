<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $routeName = $request->route()->getName();

        // Permitir rotas públicas (login/logout)
        if (in_array($routeName, ['loginGET', 'logout'])) {
            return $next($request);
        }

        // Autenticação via POST (login)
        if ($routeName === 'loginPOST') {
            $credentials = [
                'username' => $request->input('login'),
                'password' => $request->input('senha'),
            ];

            $response = $this->getApiData($credentials);

            if ($response['success']) {
                return $next($request);
            } else {
                // Apaga os dados da sessao caso digite a senha incorretamente
                session()->flush();
                return redirect()->back()->with('error', "Credenciais Inválidas");
            }
        }

        // Verifica se está logado
        if (!session()->has('aluno')) {
            return redirect()->route('loginGET');
        } 

        // Adiciona cabeçalhos de controle de cache
        $response = $next($request);
        return $response->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', '0');
    }

    public function getApiData(array $credentials): array
    {
        $apiUrl = config('services.faesa.api_url');
        $apiKey = env('FAESA_API_KEY');

        try {
            $response = Http::withHeaders([
                'Accept'        => "application/json",
                'Authorization' => $apiKey
            ])->timeout(5)->post($apiUrl, $credentials);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data'    => $response->json()
                ];
            }

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

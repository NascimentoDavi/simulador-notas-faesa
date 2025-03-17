<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Http;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthMiddleware
{
    protected $publicRoutes = ['beginning', 'logout', 'login'];

    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->route()->getName(), $this->publicRoutes)) {
            return $next($request);
        }

        if ($request->route()->getName() == 'login') {
            $credentials = [
                'username' => $request->login,
                'password' => $request->senha,
            ];

            $apiResponse = $this->getApiData($credentials);

            if ($apiResponse['status'] === 200) {
                return $next($request);
            } else {
                Log::error('Login failed: ' . $apiResponse['message']);
                return redirect()->back()->with('error', $apiResponse['message']);
            }
        }

        return $next($request);
    }

    /**
     * Faz a requisição para a API de autenticação
     *
     * @param array $credentials
     * @return array
     */
    public function getApiData(array $credentials)
    {
        $apiUrl = env('API_URL', 'http://faesa-mobile-api.faesa.br/api/v1/app-faesa/auth');
        $apiKey = env('API_KEY', 'ppzU5NqaBpzuaGDy');

        try {
            $response = Http::withHeaders([
                'Accept' => "application/json",
                "Authorization" => $apiKey
            ])
            ->withBody(json_encode($credentials), 'application/json')
            ->post($apiUrl);

            if ($response->successful()) {
                return ['status' => 200, 'message' => 'Success'];
            } else {
                return ['status' => $response->status(), 'message' => $response->body()];
            }
        } catch (\Exception $e) {
            Log::error('API request failed: ' . $e->getMessage());
            return ['status' => 500, 'message' => 'Failed to contact the authentication API'];
        }
    }
}

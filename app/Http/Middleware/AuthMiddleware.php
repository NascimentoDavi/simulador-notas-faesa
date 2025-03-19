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
        if (in_array($request->route()->getName(), ['beginning', 'logout'])) {
            return $next($request);
        }

        if ($request->route()->getName() == 'login') {
            $credentials = [
                'username' => $request->input('login'),
                'password' => $request->input('senha'),
            ];

            // API DATA
            $response = $this->getApiData($credentials);

            if ($response['success']) {
                return $next($request);
            } else {
                return redirect()->back()->with('error', "Invalid Credentials");
            }
        }

        return $next($request);
    }

    public function getApiData(array $credentials): array
    {
        $apiUrl = config('services.faesa.api_url');
        $apiKey = env('FAESA_API_KEY');

        try {
            $response = Http::withHeaders([
                'Accept'        => "application/json",
                'Authorization' => $apiKey
            ])
            ->timeout(5)
            ->post($apiUrl, $credentials);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data'    => $response->json()
                ];
            }

            return [
                'success' => false,
                'message' => 'Invalid Credentials',
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

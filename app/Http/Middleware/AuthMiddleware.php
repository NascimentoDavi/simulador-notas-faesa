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
        if ($request->route()->getName() == 'beginning') {
            return $next($request);

        } elseif ($request->route()->getName() == 'logout') {
            return $next($request);

        } elseif ($request->route()->getName() == 'login') {

            $credentials = [
                'username' => $request->login,
                'password' => $request->senha,
            ];

            // API DATA
            $return = $this->getApiData($credentials);

            if ($return == true) {
                return $next($request);
            } else {
                return redirect()->back()->with('error', "Invalid Credentials");
            }

        } else {
            return $next($request);
        }        
    }

    public function getApiData(array $credentials)
    {
        // api
        $apiUrl = 'https://faesa-mobile-api.faesa.br/api/v1/app-faesa/auth';

        $response = Http::withHeaders([
            'Accept' => "application/json",
            "Authorization" => "ppzU5NqaBpzuaGDy"
        ])
        ->withBody(json_encode($credentials),'application/json')
        ->post($apiUrl);

        dd($response->json());

        if ($response->status() == 200) {
            return true;
        } else {
            return false;
        }
    }

}
<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Http;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DB;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {

        echo "Something in the way";

        // if ($request->route()->getName() == 'beginning') {
        //     return $next($request);

        // } elseif ($request->route->getName() == 'logout') {
        //     return $next($request);

        // } elseif ($request->route()->getName() == 'login') {

        //     $credentials = [
        //         'username' => $request->login,
        //         'password' => $request->senha,
        //     ];

        //     $return = $this->getApiData($request);
        //     $encryptedData = User::select('Login', 'Senha', 'id')
        //         ->where('Login', '=', 'administrador')
        //         ->get()->toArray();
        //     $id_user = $encryptedData[0]['id'];

        //     if ($return == true) {
        //         Auth::loginUsingId($id_user);
        //         return $net($request);
        //     } else {
        //         return redirect()->back()->with('error', "Invalid Credentials");
        //     }
        // } else {
        //     return $next($request);
        // }        
    }

    public function getApiData(Request $request)
    {
        $credentials = [
            'username' => $request->login,
            'password' => $request->senha
        ];

        $api_url = 'https://api-manage-ad.faesa.br/api/v1/ad-manage/auth';

        $response = Http::withHeaders([
            'Accept' => "application/json",
            "Authorization" => "ppzU5NqaBpzuaGDy"
        ])
        ->withBody(json_encode($credentials), 'application/json')->post($apiUrl);
        if($response->status() == 200) {
            return true;
        } else {
            return false;
        }
    }
}
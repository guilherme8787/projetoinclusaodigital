<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtAuthApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->has('token')){
            $key = env('JWT_SECRET');
            try{
                $decoded = JWT::decode($request->get('token'), new Key($key, 'HS256'));
                return $next($request);
            } catch(Exception $e){
                print_r($e);
            }
        } else {
            return response()->json(['message' => 'token invalido']);
        }
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtManager extends Controller
{
    public function valid(Request $request){

        if($request->has('token')){
            $key = env('JWT_SECRET');
            try{
                $decoded = JWT::decode($request->get('token'), new Key($key, 'HS256'));
                return response()->json($decoded);
            } catch(Exception $e){
                print_r($e);
            }
        }
        
        
    }
}

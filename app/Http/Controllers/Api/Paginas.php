<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pagina;

class Paginas extends Controller
{
    public function get(Request $request){
        if($request->filled('pagina')){
            return response()->json(Pagina::where('pagina', 'like', '%'.$request->get('pagina').'%')->get());
        } else {
            return response()->json(Pagina::all());
        }
    }
}

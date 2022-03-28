<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Conteudo;
use Illuminate\Support\Arr;

class Conteudos extends Controller
{
    public function get(Request $request){

        $conteudo = new Conteudo;
        $content = null;

        $filtros = [
            'disciplina',
            'ciclo',
            'categoria',
            'descricao'
        ];

        $filtering = 0;
        foreach($filtros as $filtro){
            if($request->filled($filtro)){
                $filtering = 1;
                if(is_array($request->get($filtro))){
                    foreach($request->get($filtro) as $filterIndex => $filterValue){
                        $content[] = [$filtro, 'like', '%'.$filterValue.'%'];
                    }
                } else {
                    $content[] = [$filtro, 'like', '%'.$request->get($filtro).'%'];
                }
            }
        }
        if($filtering == 0){
            return response()->json($conteudo::all()->take(50));
        } else {
            return response()->json($conteudo::where($content)->get());
        }
    }
    
}

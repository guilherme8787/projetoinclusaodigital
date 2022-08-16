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
        $conteudo = $conteudo->query();

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
                        if ($filtro == 'descricao') {
                            $conteudo->orWhere('titulo', 'like', '% '.$request->get($filterValue).' %');
                            $conteudo->orWhere('hashtags', 'like', '% '.$request->get($filterValue).' %');
                            $conteudo->orWhere('descricao', 'like', '% '.$request->get($filterValue).' %');

                            $conteudo->orWhere('titulo', 'like', ''.$request->get($filterValue).' %');
                            $conteudo->orWhere('hashtags', 'like', ''.$request->get($filterValue).' %');
                            $conteudo->orWhere('descricao', 'like', ''.$request->get($filterValue).' %');

                            $conteudo->orWhere('titulo', 'like', '% '.$request->get($filterValue).'');
                            $conteudo->orWhere('hashtags', 'like', '% '.$request->get($filterValue).'');
                            $conteudo->orWhere('descricao', 'like', '% '.$request->get($filterValue).'');
                        } else {
                            $conteudo->where($filtro, 'like', '%'.$filterValue.'%');
                        }
                    }
                } else {
                    if ($filtro == 'descricao') {
                        $conteudo->orWhere('titulo', 'like', '% '.$request->get($filtro).' %');
                        $conteudo->orWhere('hashtag', 'like', '% '.$request->get($filtro).' %');
                        $conteudo->orWhere('descricao', 'like', '% '.$request->get($filtro).' %');

                        $conteudo->orWhere('titulo', 'like', '% '.$request->get($filtro).'');
                        $conteudo->orWhere('hashtag', 'like', '% '.$request->get($filtro).'');
                        $conteudo->orWhere('descricao', 'like', '% '.$request->get($filtro).'');
                        
                        $conteudo->orWhere('titulo', 'like', ''.$request->get($filtro).' %');
                        $conteudo->orWhere('hashtag', 'like', ''.$request->get($filtro).' %');
                        $conteudo->orWhere('descricao', 'like', ''.$request->get($filtro).' %');
                    } else {
                        $conteudo->where($filtro, 'like', '% '.$request->get($filtro).' %');
                    }
                }
            }
        }

        if($filtering == 0){
            return response()->json(Conteudo::all()->take(50));
        } else {
            return response()->json($conteudo->get());
        }
    }
    
}

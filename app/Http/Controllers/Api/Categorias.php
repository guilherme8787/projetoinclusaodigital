<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;

class Categorias extends Controller
{
    public function get(){
        $categorias = Categoria::select('categoria')->get()->unique('categoria');
        return response()->json($categorias);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Disciplina;

class Disciplinas extends Controller
{
    public function get(){
        $disciplinas = Disciplina::select('disciplina')->get()->unique('disciplina');
        return response()->json($disciplinas);
    }

}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ciclo;

class Ciclos extends Controller
{
    public function get(){
        $ciclos = Ciclo::select('ciclo')->get()->unique('ciclo');
        return response()->json($ciclos);
    }
}

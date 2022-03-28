<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;T

class Faq2s extends Controller
{
    public function get(){
        return response()->json(Faq2::all());
    }
}

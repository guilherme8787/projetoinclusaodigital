<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq1;

class Faq1s extends Controller
{
    public function get(){
        return response()->json(Faq1::all());
    }
}

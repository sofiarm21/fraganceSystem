<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Productor;

class EvaluacionController extends Controller
{

    public function index(){

        $productores = Productor::all();

        return view('evaluacion', [
            'productores' => $productores,
        ]);
    }
}

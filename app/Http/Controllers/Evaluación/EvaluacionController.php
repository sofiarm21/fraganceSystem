<?php

namespace App\Http\Controllers\Evaluación;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Productor;

class EvaluacionController extends Controller
{

    public function index(){

        $productores = Productor::all();

        return view('evaluación/evaluacion', [
            'productores' => $productores,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Productor;
use App\Variable;

class FormulaInicialController extends Controller
{


    

    public function view($id){

        $productor = Productor::findOrFail($id);
        $variables = Variable::all();

        return view('formulaInicial', [
            'productor' => $productor,
            'variables' => $variables
        ]);
    }
}

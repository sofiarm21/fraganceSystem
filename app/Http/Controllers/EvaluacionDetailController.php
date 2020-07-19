<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Productor;

class EvaluacionDetailController extends Controller
{
    public function view($id){
        echo ($id);
    
        $productor = Productor::findOrFail($id);

        return view('evaluacionDetail', [
            'productor' => $productor,
        ]);
    }
}

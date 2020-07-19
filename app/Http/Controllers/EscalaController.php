<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Escala;
use App\Productor;

class EscalaController extends Controller
{

    public function create(Request $request){

        $productor = Productor::findOrFail($id);


        return view('escala', [
            'productor' => $productor,
        ]);
    }

    public function view($id){

        $productor = Productor::findOrFail($id);


        return view('escala', [
            'productor' => $productor,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Productor;

class ComprasController extends Controller
{

    public function view(){

        $productores = Productor::all();

        return view('compras/compras', [
            'productores' => $productores,
        ]);
    }
}

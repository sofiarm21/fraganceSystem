<?php

namespace App\Http\Controllers\Evaluación;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Productor;
use App\Proveedor;
use App\Renueva;

class EvaluacionFinalResultadoController extends Controller
{
    function renueva($id_productor, $id_proveedor, $cod_contrato){

        $renueva = new Renueva();
        $renueva->id_productor = $id_productor;
        $renueva->id_proveedor = $id_proveedor;
        $renueva->cod_contrato = $cod_contrato;
        $renueva->fecha =  date('Y-m-d H:i:s');
        $renueva->save();

        return redirect()->action(
            'Evaluación\EvaluacionDetailController@view', [
                'id' => $id_productor
            ]
        );
    }

    function view($id_productor, $id_proveedor, $aprobado, $cod_contrato){
        $productor = Productor::findOrFail($id_productor);
        $proveedor = Productor::findOrFail($id_proveedor);

        $contrato = Productor::findOrFail($cod_contrato);


        return view('evaluación/evaluacionFinalResultado', [
            'productor' => $productor,
            'proveedor' => $proveedor,
            'aprobado' => $aprobado,
            'contrato' => $contrato
        ]);
    }
}

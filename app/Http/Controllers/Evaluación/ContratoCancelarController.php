<?php

namespace App\Http\Controllers\Evaluación;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\Productor;
use App\Proveedor;
use App\Contrato;

class ContratoCancelarController extends Controller
{

    public function cancelar($id_productor, $id_proveedor, $codigo_contrato, Request $request){

        DB::table('sms_contrato')
            -> where('codigo', $codigo_contrato)
            ->update([
                'fecha_cancelacion' => date('Y-m-d H:i:s'),
                'motivo_cancelacion' => $request->motivo
            ]);

        return redirect()->action(
            'Evaluación\EvaluacionDetailController@view', ['id' => $id_productor]
        );

    }

    public function view($id_productor, $id_proveedor, $codigo_contrato){

        $productor = Productor::findOrFail($id_productor);
        $proveedor = Proveedor::findOrFail($id_proveedor);
        $contrato = Contrato::findOrFail($codigo_contrato);


        return view('evaluación/contratoCancelar', [
            'productor' => $productor,
            'proveedor' => $proveedor,
            'contrato' => $contrato,
        ]);
    }
}

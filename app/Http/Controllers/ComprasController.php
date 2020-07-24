<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Productor;

class ComprasController extends Controller
{
    function getContratosActivos($id_productor){

        $contratos = DB::table('sms_contrato')
        ->join('sms_proveedores','sms_contrato.id_proveedor','=','sms_proveedores.id')
        ->where('sms_contrato.id_productor','=',$id_productor)
        ->where('sms_contrato.fecha_cancelacion','=',null)
        ->where('sms_contrato.motivo_no_renovacion','=',null)
        ->select(
                'sms_proveedores.nombre',
                'sms_contrato.id_proveedor',
                'sms_contrato.codigo',
                'sms_contrato.fecha'
            )
        ->distinct()
        ->get();

        return $contratos;
    }


    public function view(){

        $productores = Productor::all();

        return view('compras', [
            'productores' => $productores,
        ]);
    }
}

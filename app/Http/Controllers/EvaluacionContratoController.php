<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Productor;
use App\Proveedor;


class EvaluacionContratoController extends Controller
{
    public function view($id_productor, $id_proveedor){

        $productor = Productor::findOrFail($id_productor);
        //$proveedor = Proveedor::findOrFail($id_proveedor);

        $proveedor = DB::table('sms_proveedores')
        ->join('sms_paises','sms_paises.codigo','=','sms_proveedores.cod_pais')
        ->where('sms_proveedores.id','=',$id_proveedor)
        ->select(
            'sms_proveedores.nombre AS proveedor_nombre',
            'sms_proveedores.pag_web AS proveedor_pag_web',
            'sms_proveedores.telefono AS proveedor_telefono',
            'sms_proveedores.correo AS proveedor_correo',
            'sms_proveedores.desc_ubicacion AS proveedor_desc_ubicacion',
            'sms_paises.nombre AS pais_nombre'
        )
        ->distinct()
        ->get();


        $productos = DB::table('sms_materia_prima_esencias')
        ->select(
            'sms_materia_prima_esencias.nombre',
            'sms_materia_prima_esencias.nombre_alternativo',
            'sms_materia_prima_esencias.num_ipc',
            'sms_materia_prima_esencias.num_tsca_cas',
            'sms_materia_prima_esencias.num_einecs',
            'sms_materia_prima_esencias.descripcion_visual',
            'sms_materia_prima_esencias.vida_util',
            'sms_materia_prima_esencias.solubilidad',
            'sms_materia_prima_esencias.inflamabilidad',
            'sms_materia_prima_esencias.proceso'
        )
        ->from('sms_materia_prima_esencias')
        ->where('sms_materia_prima_esencias.id_proveedor', '=', $id_proveedor)
        ->distinct()
        ->get();

        return view('evaluacionContrato', [
            'productor' => $productor,
            'proveedor' => $proveedor,
            'productos' => $productos
        ]);
    }
}

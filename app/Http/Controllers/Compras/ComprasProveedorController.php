<?php

namespace App\Http\Controllers\Compras;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Productor;
use App\Proveedor;

class ComprasProveedorController extends Controller
{

    function getContrato($id_productor, $id_proveedor){
        $contrato = DB::table('sms_contrato')
        ->select('sms_contrato.codigo')
        ->where('sms_contrato.id_proveedor','=',$id_proveedor)
        ->where('sms_contrato.id_productor','=',$id_productor)
        ->where('sms_contrato.motivo_no_renovacion','=',null)
        ->where('sms_contrato.fecha_cancelacion','=',null)
        ->distinct()
        ->get();
        return $contrato[0];
    }

    function getProductosContratados($id_productor, $id_proveedor){
        $productos_contratados= DB::table('sms_contrato')
        ->join('sms_det_contrato','sms_contrato.codigo','=','sms_det_contrato.cod_contrato')
        ->where('sms_contrato.id_proveedor','=',$id_proveedor)
        ->where('sms_contrato.id_productor','=',$id_productor)
        ->join('sms_materia_prima_esencias','sms_det_contrato.cod_mp_esencia','=','sms_materia_prima_esencias.codigo')
        ->select(
            'sms_materia_prima_esencias.codigo',
            'sms_materia_prima_esencias.nombre',
            'sms_materia_prima_esencias.nombre_alternativo',
            'sms_materia_prima_esencias.num_ipc',
            'sms_materia_prima_esencias.num_tsca_cas',
            'sms_materia_prima_esencias.num_einecs',
            'sms_materia_prima_esencias.descripcion_visual',
            'sms_materia_prima_esencias.vida_util',
            'sms_materia_prima_esencias.solubilidad',
            'sms_materia_prima_esencias.inflamabilidad',
            'sms_materia_prima_esencias.proceso',
        )
        ->distinct()
        ->get();

        return ($productos_contratados);
    }

    function getOtrosProductosContratados($id_productor, $id_proveedor){
        $contrato = self::getContrato($id_productor, $id_proveedor);
        $otros_productos_contratados= DB::table('sms_contrato')
        ->join('sms_det_contrato','sms_contrato.codigo','=','sms_det_contrato.cod_contrato')
        ->where('sms_contrato.id_proveedor','=',$id_proveedor)
        ->where('sms_contrato.id_productor','=',$id_productor)
        ->join('sms_componente_ing_otros','sms_det_contrato.cod_componente_ing','=','sms_componente_ing_otros.codigo')
        ->where('sms_det_contrato.cod_contrato','=',$contrato->codigo)
        ->select(
            'sms_componente_ing_otros.nombre',
            'sms_componente_ing_otros.tsca_cas',
            'sms_componente_ing_otros.ipc',
        )
        ->distinct()
        ->get();

        return ($otros_productos_contratados);


    }

    function getCondicionesPago($id_productor, $id_proveedor){
        $condiciones_pago= DB::table('sms_contrato')
        ->join('sms_c_p','sms_contrato.codigo','=','sms_c_p.cod_contrato')
        ->where('sms_contrato.id_proveedor','=',$id_proveedor)
        ->where('sms_contrato.id_productor','=',$id_productor)
        ->join('sms_condicion_pago','sms_c_p.cod_cond_pago','=','sms_condicion_pago.codigo')
        ->where('sms_c_p.id_proveedor_contrato','=',$id_proveedor)
        ->where('sms_c_p.id_productor_contrato','=',$id_productor)
        ->leftJoin('sms_cuotas','sms_condicion_pago.codigo','=','sms_cuotas.cod_cond_pago')
        ->where('sms_condicion_pago.id_proveedor','=',$id_proveedor)
        ->select(
            'sms_condicion_pago.tipo',
            'sms_condicion_pago.cantidad_cuotas',
            'sms_condicion_pago.codigo',
            'sms_cuotas.porcentaje_pago AS pago_porcentajes',
            'sms_cuotas.tiempo_para_pago AS pago_dias',
            'sms_cuotas.porcentaje_recargo',
            'sms_cuotas.porcentaje_descuento',
            'sms_cuotas.cod_cond_pago',

        )
        ->distinct()
        ->get();

        return ($condiciones_pago);
    }


    function getCondicionesEnvio($id_productor, $id_proveedor){
        $condicionesEnvio = DB::table('sms_contrato')
        ->join('sms_c_e','sms_contrato.codigo','=','sms_c_e.cod_contrato')
        ->where('sms_contrato.id_proveedor','=',$id_proveedor)
        ->where('sms_contrato.id_productor','=',$id_productor)
        ->join('sms_envio','sms_c_e.cod_pais_envio','=','sms_envio.cod_pais')
        ->join('sms_paises','sms_envio.cod_pais','=','sms_paises.codigo')
        ->where('sms_envio.id_proveedor','=',$id_proveedor)
        ->where('sms_envio.id_proveedor','=',$id_proveedor)
        ->select(
            'sms_envio.tipo_transporte AS envio_transporte',
            'sms_envio.costo AS envio_costo',
            'sms_envio.cod_pais',
            'sms_paises.nombre AS envio_pais'
        )
        ->distinct()
        ->get();

        return ($condicionesEnvio);
    }


    public function view($id_productor, $id_proveedor){

        $productor = Productor::findOrFail($id_productor);
        $proveedor = Proveedor::findOrFail($id_proveedor);
        $productos_contratados = self::getProductosContratados($id_productor, $id_proveedor);
        $otros_productos_contratados = self::getOtrosProductosContratados($id_productor, $id_proveedor);
        $condiciones_pago = self::getCondicionesPago($id_productor, $id_proveedor);
        $condiciones_envio = self::getCondicionesEnvio($id_productor, $id_proveedor);


        return view('compras/comprasProveedor', [
            'proveedor' => $proveedor,
            'productor' => $productor,
            'productos_contratados' => $productos_contratados,
            'ingredientes_otros' => $otros_productos_contratados,
            'condiciones_pago' => $condiciones_pago,
            'condiciones_envio'=> $condiciones_envio

        ]);

    }
}

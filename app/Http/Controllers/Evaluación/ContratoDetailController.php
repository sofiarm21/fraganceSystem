<?php

namespace App\Http\Controllers\Evaluación;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Productor;
use App\Proveedor;
use App\Contrato;

class ContratoDetailController extends Controller
{
    function getContratos($id_productor){

        $contratos = DB::table('sms_contrato')
        ->join('sms_proveedores','sms_contrato.id_proveedor','=','sms_proveedores.id')
        ->where('sms_contrato.id_productor','=',$id_productor)
        ->select(
                'sms_proveedores.nombre',
                'sms_contrato.fecha'
            )
        ->distinct()
        ->get();

        return $contratos;
    }




    public function view($id_productor, $id_proveedor, $codigo_contrato){

        $productor = Productor::findOrFail($id_productor);
        $proveedor = Proveedor::findOrFail($id_proveedor);
        $contrato = Contrato::findOrFail($codigo_contrato);


        $productos_contratados = DB::table('sms_det_contrato')
        ->join('sms_materia_prima_esencias','sms_det_contrato.cod_mp_esencia','=','sms_materia_prima_esencias.codigo')
        ->where('sms_det_contrato.cod_contrato','=',$codigo_contrato)
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


        $ingredientes_otros_contratados = DB::table('sms_det_contrato')
        ->join('sms_componente_ing_otros','sms_det_contrato.cod_componente_ing','=','sms_componente_ing_otros.codigo')
        ->where('sms_det_contrato.cod_contrato','=',$codigo_contrato)
        ->select(
            'sms_componente_ing_otros.nombre',
            'sms_componente_ing_otros.tsca_cas',
            'sms_componente_ing_otros.ipc',
        )
        ->distinct()
        ->get();


        $condiciones_pago = DB::table('sms_c_p')
        ->join('sms_condicion_pago','sms_condicion_pago.codigo','=','sms_c_p.cod_cond_pago')
        ->where('sms_c_p.cod_contrato','=',$codigo_contrato)
        ->leftJoin('sms_cuotas','sms_condicion_pago.codigo','=','sms_cuotas.cod_cond_pago')
        ->where('sms_condicion_pago.id_proveedor','=',$id_proveedor)
        ->select(
            'sms_condicion_pago.tipo',
            'sms_condicion_pago.cantidad_cuotas',
            'sms_cuotas.porcentaje_pago AS pago_porcentajes',
            'sms_cuotas.tiempo_para_pago AS pago_dias',
            'sms_cuotas.porcentaje_recargo',
            'sms_cuotas.porcentaje_descuento',
            'sms_cuotas.cod_cond_pago',
            'sms_condicion_pago.codigo'
        )
        ->distinct()
        ->get();

        $condiciones_envio = DB::table('sms_c_e')
        ->join('sms_envio','sms_c_e.cod_pais_envio','=','sms_envio.cod_pais')
        ->where('sms_c_e.cod_contrato','=',$codigo_contrato)
        ->join('sms_paises','sms_envio.cod_pais','=','sms_paises.codigo')
        ->where('sms_envio.id_proveedor','=',$id_proveedor)
        ->select(
            'sms_envio.tipo_transporte AS envio_transporte',
            'sms_envio.costo AS envio_costo',
            'sms_envio.cod_pais',
            'sms_paises.nombre AS envio_pais'
        )
        ->distinct()
        ->get();


        return view('evaluación/contratoDetail', [
            'productor' => $productor,
            'proveedor' => $proveedor,
            'contrato' => $contrato,
            'productos' => $productos_contratados,
            'ingredientes_otros' => $ingredientes_otros_contratados,
            'condiciones_pago' => $condiciones_pago,
            'condiciones_envio' => $condiciones_envio,
        ]);
    }

}

<?php

namespace App\Http\Controllers\Compras;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Productor;
use App\Proveedor;
use App\Pedido;


class PedidoDetailController extends Controller
{
    function getPresentaciones($id_pedido){
        $pedido = DB::table('sms_pedido')
        ->join('sms_det_pedido','sms_pedido.codigo','=','sms_det_pedido.cod_pedido')
        ->where('sms_pedido.codigo','=',$id_pedido)
        ->join('sms_presentacion_mp','sms_det_pedido.id_presentacion_mp', '=', 'sms_presentacion_mp.id')
        ->select(
            'sms_presentacion_mp.id',
            'sms_det_pedido.cantidad'
        )
        ->get();
        return $pedido;
    }

    function getIngredientes($id_presentacion){
        $ingredientes = DB::table('sms_presentacion_mp')
        ->join('sms_materia_prima_esencias','sms_presentacion_mp.cod_materia_prima','=','sms_materia_prima_esencias.codigo')
        ->where('sms_presentacion_mp.id','=',$id_presentacion)
        ->select(
            'sms_materia_prima_esencias.nombre',
            'sms_materia_prima_esencias.nombre_alternativo',
            'sms_materia_prima_esencias.num_ipc',
            'sms_materia_prima_esencias.num_tsca_cas',
            'sms_materia_prima_esencias.num_einecs',
            'sms_materia_prima_esencias.descripcion_visual',
            'sms_materia_prima_esencias.vida_util',
            'sms_presentacion_mp.volml',
            'sms_presentacion_mp.precio',
            'sms_presentacion_mp.otro'
            )
        ->get();
        return $ingredientes;
    }

    function getOtrosIngredientes($id_presentacion){
        $ingredientes = DB::table('sms_presentacion_mp')
        ->join('sms_componente_ing_otros', 'sms_presentacion_mp.cod_componente_ing','=','sms_componente_ing_otros.codigo')
        ->where('sms_presentacion_mp.id','=',$id_presentacion)
        ->select(
            'sms_componente_ing_otros.nombre',
            'sms_presentacion_mp.volml',
            'sms_presentacion_mp.precio',
            'sms_presentacion_mp.otro'
            )
        ->get();
        return $ingredientes;
    }

    function getMetodoEnvio($id_pedido){
        $envio = DB::table('sms_pedido')
        ->join('sms_envio','sms_pedido.cod_pais_c_e','=','sms_envio.cod_pais')
        ->where('sms_pedido.codigo','=',$id_pedido)
        ->join('sms_paises','sms_envio.cod_pais','=','sms_paises.codigo')
        ->select(
            'sms_envio.tipo_transporte',
            'sms_envio.costo',
            'sms_paises.nombre'
            )
        ->get();
        return $envio;
    }

    function getMetodoPago($id_pedido){
        $pago = DB::table('sms_pedido')
        ->join('sms_c_p','sms_pedido.cod_cond_pago_c_p','=','sms_c_p.cod_cond_pago')
        ->where('sms_pedido.codigo','=', $id_pedido)
        ->join('sms_condicion_pago','sms_c_p.cod_cond_pago','=','sms_condicion_pago.codigo')
        ->leftJoin('sms_cuotas','sms_condicion_pago.codigo','=','sms_cuotas.cod_cond_pago')
        ->select(
            'sms_c_p.cod_cond_pago',
            'sms_condicion_pago.tipo',
            'sms_condicion_pago.cantidad_cuotas',
            'sms_condicion_pago.descripcion',
            'sms_cuotas.porcentaje_pago',
            'sms_cuotas.tiempo_para_pago',
            'sms_cuotas.porcentaje_descuento',
            'sms_cuotas.porcentaje_recargo',
            )
        ->get();
        return $pago;
    }

    public function view($id_productor, $id_proveedor, $id_pedido){

        $productor = Productor::findOrFail($id_productor);
        $proveedor = Proveedor::findOrFail($id_proveedor);
        $pedido = Pedido::findOrFail($id_pedido);

        $presentaciones = self::getPresentaciones($id_pedido);
        $pago = self::getMetodoPago($id_pedido);
        $envio = self::getMetodoEnvio($id_pedido);

        $ingredientes = [];
        $otros_ingredientes = [];

        foreach ($presentaciones as $presentacion){
            array_push($ingredientes, self::getIngredientes($presentacion->id));
        }
        foreach ($presentaciones as $presentacion){
            array_push($otros_ingredientes, self::getOtrosIngredientes($presentacion->id));
        }


        return view('compras/comprasPedidoDetail', [
            'proveedor' => $proveedor,
            'productor' => $productor,
            'pedido' => $pedido,
            'ingredientes' => $ingredientes,
            'ingredientes_otros' => $otros_ingredientes,
            'metodos_pago' => $pago,
            'envio' => $envio
        ]);



    }
}

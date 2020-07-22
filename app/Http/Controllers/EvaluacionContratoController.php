<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Productor;
use App\Proveedor;
use App\Variable;
use App\EvaluacionResultado;


class EvaluacionContratoController extends Controller
{

    public function evaluar($id_productor, $id_proveedor, Request $request){

        $productor = Productor::findOrFail($id_productor);
        $proveedor = Proveedor::findOrFail($id_proveedor);

        $formula_inicial = DB::table('sms_eval_criterio')
        ->join('sms_escala','sms_eval_criterio.id_productor','=', 'sms_eval_criterio.id_productor')
        ->where('sms_eval_criterio.id_productor','=',$id_productor)
        ->where('sms_eval_criterio.fecha_final','=',null)
        ->where('sms_eval_criterio.tipo_formula','=','i')
        ->where('sms_escala.fecha_final','=',null)
        ->select(
            'sms_eval_criterio.id_variable',
            'sms_eval_criterio.peso',
            'sms_escala.rango_inicial',
            'sms_escala.rango_final',
        )
        ->get();

        foreach ($formula_inicial as $variable){
            if (($request->input($variable->id_variable) > 10) || ($request->input($variable->id_variable) < 1)){
                return back()->withInput();
            }

        }

        $evaluacion_resultado = new EvaluacionResultado();
        $evaluacion_resultado->id_productor=$id_productor;
        $evaluacion_resultado->id_proveedor=$id_proveedor;
        $evaluacion_resultado->fecha_realizada = date('Y-m-d H:i:s');
        $evaluacion_resultado->tipo_eval = 'i';

        $suma = 0;
        foreach ($formula_inicial as $variable){
            $suma += $request->input($variable->id_variable) * ($variable->peso / 100);

        }

        $evaluacion_resultado->resultado = $suma;
        $evaluacion_resultado->save();

        $aprobado = false;
        if ($evaluacion_resultado->resultado > (0.8 * ($formula_inicial[0]->rango_final - $formula_inicial[0]->rango_inicial)) / 10){
            $aprobado = true;
        }

        return view('evaluacionResultado', [
            'productor' => $productor,
            'proveedor' => $proveedor,
            'aprobado' => $aprobado
        ]);

    }





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


        // $productos = DB::table('sms_materia_prima_esencias')
        // ->select(
        //     'sms_materia_prima_esencias.nombre',
        //     'sms_materia_prima_esencias.nombre_alternativo',
        //     'sms_materia_prima_esencias.num_ipc',
        //     'sms_materia_prima_esencias.num_tsca_cas',
        //     'sms_materia_prima_esencias.num_einecs',
        //     'sms_materia_prima_esencias.descripcion_visual',
        //     'sms_materia_prima_esencias.vida_util',
        //     'sms_materia_prima_esencias.solubilidad',
        //     'sms_materia_prima_esencias.inflamabilidad',
        //     'sms_materia_prima_esencias.proceso'
        // )
        // ->from('sms_materia_prima_esencias')
        // ->where('sms_materia_prima_esencias.id_proveedor', '=', $id_proveedor)
        // ->distinct()
        // ->get();

        $productos = DB::table('sms_materia_prima_esencias')
        ->join('sms_presentacion_mp', 'sms_materia_prima_esencias.codigo','=','sms_presentacion_mp.cod_materia_prima')
        ->where('sms_materia_prima_esencias.id_proveedor', '=', $id_proveedor)
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
            'sms_presentacion_mp.precio',
            'sms_presentacion_mp.volml'
        )
        ->distinct()
        ->get();


        //verificar cuando existan contratos
        // $productos = DB::table('sms_contrato')
        // ->join('sms_det_contrato','sms_contrato.codigo','=','sms_det_contrato.cod_contrato')
        // ->where('sms_contrato.id_proveedor', '=', $id_proveedor)
        // ->where('sms_contrato.exclusividad', '=', false)
        // ->join('sms_materia_prima_esencias','sms_det_contrato.cod_mp_esencia','=','sms_materia_prima_esencias.codigo')
        // ->where('sms_materia_prima_esencias.id_proveedor', '=', $id_proveedor)
        // ->select(
        //     'sms_materia_prima_esencias.nombre',
        //     'sms_materia_prima_esencias.nombre_alternativo',
        //     'sms_materia_prima_esencias.num_ipc',
        //     'sms_materia_prima_esencias.num_tsca_cas',
        //     'sms_materia_prima_esencias.num_einecs',
        //     'sms_materia_prima_esencias.descripcion_visual',
        //     'sms_materia_prima_esencias.vida_util',
        //     'sms_materia_prima_esencias.solubilidad',
        //     'sms_materia_prima_esencias.inflamabilidad',
        //     'sms_materia_prima_esencias.proceso'
        // )
        // ->distinct()
        // ->get();


        //verificar cuando existan contratos
        // $productos = DB::table('sms_materia_prima_esencias')
        // ->join('sms_presentacion_mp', 'sms_materia_prima_esencias.codigo','=','sms_presentacion_mp.cod_materia_prima')
        // ->where('sms_materia_prima_esencias.id_proveedor', '=', $id_proveedor)
        // ->join('sms_det_contrato','sms_contrato.codigo','=','sms_det_contrato.cod_contrato')
        // ->where('sms_contrato.id_proveedor', '=', $id_proveedor)
        // ->where('sms_contrato.exclusividad', '=', false)
        // ->join('sms_materia_prima_esencias','sms_det_contrato.cod_mp_esencia','=','sms_materia_prima_esencias.codigo')
        // ->where('sms_materia_prima_esencias.id_proveedor', '=', $id_proveedor)
        // ->select(
        //     'sms_materia_prima_esencias.nombre',
        //     'sms_materia_prima_esencias.nombre_alternativo',
        //     'sms_materia_prima_esencias.num_ipc',
        //     'sms_materia_prima_esencias.num_tsca_cas',
        //     'sms_materia_prima_esencias.num_einecs',
        //     'sms_materia_prima_esencias.descripcion_visual',
        //     'sms_materia_prima_esencias.vida_util',
        //     'sms_materia_prima_esencias.solubilidad',
        //     'sms_materia_prima_esencias.inflamabilidad',
        //     'sms_materia_prima_esencias.proceso'
        // )
        // ->distinct()
        // ->get();

        $productos_contratados = DB::table('sms_contrato')
        ->join('sms_det_contrato','sms_contrato.codigo','=','sms_det_contrato.cod_contrato')
        ->where('sms_contrato.id_proveedor', '=', $id_proveedor)
        ->join('sms_materia_prima_esencias','sms_det_contrato.cod_mp_esencia','=','sms_materia_prima_esencias.codigo')
        ->where('sms_materia_prima_esencias.id_proveedor', '=', $id_proveedor)
        ->join('sms_presentacion_mp', 'sms_materia_prima_esencias.codigo','=','sms_presentacion_mp.cod_materia_prima')
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
            'sms_contrato.exclusividad',
            'sms_presentacion_mp.precio',
            'sms_presentacion_mp.volml'
        )
        ->distinct()
        ->get();


        // $productos = DB::table('sms_materia_prima_esencias')
        // ->join('sms_presentacion_mp', 'sms_materia_prima_esencias.codigo','=','sms_presentacion_mp.cod_materia_prima')
        // ->where('sms_materia_prima_esencias.id_proveedor', '=', $id_proveedor)
        // ->join('sms_det_contrato', 'sms_materia_prima_esencias.codigo','=','sms_det_contrato.cod_mp_esencia')
        // ->where('sms_materia_prima_esencias.id_proveedor', '=', $id_proveedor)
        // ->join('sms_contrato','sms_det_contrato.cod_contrato','=','sms_contrato.codigo')
        // ->where('sms_materia_prima_esencias.id_proveedor', '=', $id_proveedor)
        // ->select(
        //     'sms_materia_prima_esencias.codigo',
        //     'sms_materia_prima_esencias.nombre',
        //     'sms_materia_prima_esencias.nombre_alternativo',
        //     'sms_materia_prima_esencias.num_ipc',
        //     'sms_materia_prima_esencias.num_tsca_cas',
        //     'sms_materia_prima_esencias.num_einecs',
        //     'sms_materia_prima_esencias.descripcion_visual',
        //     'sms_materia_prima_esencias.vida_util',
        //     'sms_materia_prima_esencias.solubilidad',
        //     'sms_materia_prima_esencias.inflamabilidad',
        //     'sms_materia_prima_esencias.proceso',
        //     'sms_presentacion_mp.precio',
        //     'sms_presentacion_mp.volml'
        // )
        // ->distinct()
        // ->get();





        // $productos_disponibles = DB::table('sms_contrato')
        // ->join('sms_det_contrato','sms_contrato.codigo','=','sms_det_contrato.cod_contrato')
        // ->where('sms_contrato.id_proveedor', '=', $id_proveedor)
        // ->join('sms_materia_prima_esencias','sms_det_contrato.cod_mp_esencia','=','sms_materia_prima_esencias.codigo')
        // ->where('sms_materia_prima_esencias.id_proveedor', '=', $id_proveedor)
        // ->where('sms_contrato.exclusividad', '=', false)
        // ->join('sms_presentacion_mp', 'sms_materia_prima_esencias.codigo','=','sms_presentacion_mp.cod_materia_prima')
        // ->where('sms_materia_prima_esencias.id_proveedor', '=', $id_proveedor)
        // ->whereExists(function ($query) {
        //     ->select("items_city.id")

        //$productos_disponibles = [];
        // if (empty($productos_contratados) == false){
        //     foreach ($productos_contratados as $producto_contratado){
        //         if ($productos->where($productos->codigo = $producto_contratado->codigo)){
        //             if ($productos->codigo == $producto_contratado->codigo){
        //                 if ($producto_contratado->exclusividad == false){
        //                     var_dump($producto_contratado->nombre);
        //                     array_push($productos_disponibles, $producto_contratado);
        //                 }else{
        //
        //                 }
        //             }
        //         }
        //     }
        // }else{
        //     $productos_disponibles = $productos;
        // }
        //
        // foreach($productos as $producto){
        //     $encontrado = false;
        //     foreach($productos_contratados as $producto_contratado){
        //         var_dump($producto_contratado->nombre);
        //         if (($producto->codigo == $producto_contratado->codigo) AND ($producto_contratado->exclusividad == false)){
        //             //echo " no exclusivo";
        //             array_push($productos_disponibles, $producto_contratado);
        //             $encontrado = true;
        //         }else if ($producto->codigo == $producto_contratado->codigo){
        //             //echo "exclusivo";
        //             $encontrado = true;
        //         }
        //     }
        //     if ($encontrado == false){
        //         echo "No encontrado";
        //         var_dump($producto->nombre);
        //         array_push($productos_disponibles, $producto);
        //     }
        // }


        // $productos_disponibles = DB::table( 'sms_det_contrato')
        //     ->select('sms_det_contrato.cod_mp_esencia')
        //     ->FROM('sms_det_contrato')
        //     ->WHERE( 'sms_det_contrato.id_proveedor' '=' '$id_proveedor') AND
        //     (
        //         ->select('sms_contrato.exclusividad')
        //         ->FROM('sms_contrato')
        //         ->WHERE sms_contrato.codigo = sms_det_contrato.cod_contrato AND sms_contrato.id_proveedor = sms_det_contrato.id_proveedor
        //     )
        //     ) );



        $productos_disponibles = DB::table('sms_materia_prima_esencias')
        ->join('sms_presentacion_mp', 'sms_materia_prima_esencias.codigo','=','sms_presentacion_mp.cod_materia_prima')
        ->where('sms_materia_prima_esencias.id_proveedor','=', $id_proveedor)
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
            'sms_presentacion_mp.precio',
            'sms_presentacion_mp.volml'
        )
        ->whereNotExists(function ($query) {
             $query->select(DB::raw(1))
                 ->from('sms_det_contrato')
                 ->join('sms_contrato', 'sms_det_contrato.cod_contrato','=','sms_contrato.codigo')
                 ->whereRaw('sms_det_contrato.cod_mp_esencia = sms_materia_prima_esencias.codigo AND sms_contrato.exclusividad = true');

        })
         ->get();



        foreach ($productos_disponibles as $producto){
            var_dump($producto->nombre);
        }





        $condiciones_pago = DB::table('sms_condicion_pago')
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
        )
        ->distinct()
        ->get();

        $condiciones_envio = DB::table('sms_envio')
        ->join('sms_paises','sms_envio.cod_pais','=','sms_paises.codigo')
        ->where('sms_envio.id_proveedor','=',$id_proveedor)
        ->select('sms_envio.tipo_transporte AS envio_transporte','sms_envio.costo AS envio_costo','sms_paises.nombre AS envio_pais')
        ->distinct()
        ->get();

        $formula_inicial = DB::table('sms_eval_criterio')
        ->select('sms_eval_criterio.id_variable', 'sms_eval_criterio.peso')
        ->from('sms_eval_criterio')
        ->where('sms_eval_criterio.id_productor','=',$id_productor)
        ->where('sms_eval_criterio.tipo_formula','=','i')
        ->where('sms_eval_criterio.fecha_final','=',null)
        ->get();

        $variables = DB::table('sms_variable')
        ->where('sms_variable.tipo','=','i')
        ->get();


        return view('evaluacionContrato', [
            'productor' => $productor,
            'proveedor' => $proveedor,
            'id_proveedor' => $id_proveedor,
            'productos' => $productos_disponibles,
            'condiciones_pago' => $condiciones_pago,
            'condiciones_envio' => $condiciones_envio,
            'variables' => $variables
        ]);
    }
}

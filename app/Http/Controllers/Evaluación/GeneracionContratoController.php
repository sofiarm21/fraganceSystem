<?php

namespace App\Http\Controllers\Evaluación;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Productor;
use App\Proveedor;
use App\Contrato;

class GeneracionContratoController extends Controller
{

    function getProductosDisponibles(int $id_proveedor){

        // $productos = DB::table('sms_materia_prima_esencias')
        // ->join('sms_presentacion_mp', 'sms_materia_prima_esencias.codigo','=','sms_presentacion_mp.cod_materia_prima')
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

        // $productos_contratados = DB::table('sms_contrato')
        // ->join('sms_det_contrato','sms_contrato.codigo','=','sms_det_contrato.cod_contrato')
        // ->where('sms_contrato.id_proveedor', '=', $id_proveedor)
        // ->join('sms_materia_prima_esencias','sms_det_contrato.cod_mp_esencia','=','sms_materia_prima_esencias.codigo')
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
        //     'sms_contrato.exclusividad'
        // )
        // ->distinct()
        // ->get();

        // $productos_disponibles = null;
        //
        // if (empty($productos_contratados) != false){
        //     foreach ($productos_contratados as $producto_contratado){
        //         if ($productos->where($productos->codigo = $producto_contratado->codigo)->exists()){
        //             if ($producto->codigo == $producto_contratado->codigo){
        //                 if ($producto_contratado->exclusividad == false){
        //                     array_push($productos_disponibles, $producto_contratado);
        //                 }
        //             }
        //         }else{
        //
        //             array_push($productos_disponibles, $producto_contratado);
        //         }
        //     }
        // }else{
        //     $productos_disponibles = $productos;
        // }
        //
        // return $productos_disponibles;

        $productos_disponibles = DB::table('sms_materia_prima_esencias')
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
        )
        ->whereNotExists(function ($query) {
             $query->select(DB::raw(1))
                 ->from('sms_det_contrato')
                 ->join('sms_contrato', 'sms_det_contrato.cod_contrato','=','sms_contrato.codigo')
                 ->whereRaw('sms_det_contrato.cod_mp_esencia = sms_materia_prima_esencias.codigo AND sms_contrato.exclusividad = true');

        })
         ->get();

         return $productos_disponibles;
    }

    function getMateriasPrimasDisponibles($id_proveedor){
        $otras_materias_disponibles = DB::table('sms_componente_ing_otros')
        ->where('sms_componente_ing_otros.id_proveedor','=',$id_proveedor)
        ->select(
            'sms_componente_ing_otros.codigo',
            'sms_componente_ing_otros.nombre',
            'sms_componente_ing_otros.ipc AS num_ipc',
            'sms_componente_ing_otros.tsca_cas AS num_tsca_cas',
        )
        ->whereNotExists(function ($query) {
             $query->select(DB::raw(1))
                 ->from('sms_det_contrato')
                 ->join('sms_contrato', 'sms_det_contrato.cod_contrato','=','sms_contrato.codigo')
                 ->whereRaw('sms_det_contrato.cod_componente_ing = sms_componente_ing_otros.codigo AND sms_contrato.exclusividad = true');

        })
         ->get();
         return $otras_materias_disponibles;
    }


    function getCondicionesPago($id_proveedor){
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
            'sms_condicion_pago.codigo'
        )
        ->distinct()
        ->get();
        return $condiciones_pago;
    }


    function getCondicionesEnvio($id_productor, $id_proveedor){
        $condiciones_envio = DB::table('sms_envio')
        ->join('sms_p_pais','sms_envio.cod_pais','=','sms_p_pais.cod_pais')
        ->where('sms_p_pais.id_productor','=',$id_productor)
        ->join('sms_paises','sms_p_pais.cod_pais','=','sms_paises.codigo')
        ->where('sms_envio.id_proveedor','=',$id_proveedor)
        ->select(
            'sms_envio.tipo_transporte AS envio_transporte',
            'sms_envio.costo AS envio_costo',
            'sms_envio.cod_pais',
            'sms_paises.nombre AS envio_pais'
        )
        ->distinct()
        ->get();
        return $condiciones_envio;
    }


    public function create($id_productor, $id_proveedor, Request $request){


        if(($request->producto_codigo == null) || ($request->condiciones_pago == null) || ($request->condicion_envio == null)){
            return back()->withInput();
        }

        $productor = Productor::findOrFail($id_productor);

        $contrato = new Contrato();
        $contrato->id_productor = $id_productor;
        $contrato->id_proveedor = $id_proveedor;
        $contrato->fecha = date('Y-m-d H:i:s');
        if ($request->exclusividad != null){
            $contrato->exclusividad = true;
        }else{
            $contrato->exclusividad = false;
        }


        $contrato->save();


        $productos_disponibles = self::getProductosDisponibles($id_proveedor);
        $otras_materias_disponibles = self::getMateriasPrimasDisponibles($id_proveedor);
        $condiciones_pago = self::getCondicionesPago($id_proveedor);
        $condiciones_envio = self::getCondicionesEnvio($id_productor, $id_proveedor);

        foreach($request->producto_codigo as $producto_codigo){

                DB::table('sms_det_contrato')->insert(
                    [
                        'cod_contrato' => $contrato->codigo,
                        'id_productor' => $id_productor,
                        'id_proveedor' => $id_proveedor,
                        'cod_mp_esencia' => $producto_codigo
                    ]
                );
        }
        if ($request->ingrediente_codigo != null){
            foreach($request->ingrediente_codigo as $ingrediente_codigo){
                echo "seleccionado $$ingrediente_codigo";
                    DB::table('sms_det_contrato')->insert(
                        [
                            'cod_contrato' => $contrato->codigo,
                            'id_productor' => $id_productor,
                            'id_proveedor' => $id_proveedor,
                            'cod_componente_ing' => $ingrediente_codigo
                        ]
                    );

            }
        }

        foreach($request->condiciones_pago as $cod_condicion_pago){


                DB::table('sms_c_p')->insert(
                    [
                        'cod_contrato' => $contrato->codigo,
                        'id_productor_contrato' => $id_productor,
                        'id_proveedor_contrato' => $id_proveedor,
                        'cod_cond_pago' => $cod_condicion_pago[0]
                    ]
                );



        }

        foreach($request->condicion_envio as $condicion_envio){

            DB::table('sms_c_e')->insert(
                [
                    'cod_contrato' => $contrato->codigo,
                    'id_productor_contrato' => $id_productor,
                    'id_proveedor_contrato' => $id_proveedor,
                    'id_proveedor_envio' => $id_proveedor,
                    'cod_pais_envio' => $condicion_envio
                ]
            );
        }


        return redirect()->action('Evaluación\EvaluacionDetailController@view', ['id' => $id_productor]);



    }




    public function view($id_productor, $id_proveedor){

        $productor = Productor::findOrFail($id_productor);

        $proveedor = DB::table('sms_proveedores')
        ->join('sms_paises','sms_paises.codigo','=','sms_proveedores.cod_pais')
        ->where('sms_proveedores.id','=',$id_proveedor)
        ->select(
            'sms_proveedores.id',
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
        // ->join('sms_presentacion_mp', 'sms_materia_prima_esencias.codigo','=','sms_presentacion_mp.cod_materia_prima')
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


        // $productos_contratados = DB::table('sms_contrato')
        // ->join('sms_det_contrato','sms_contrato.codigo','=','sms_det_contrato.cod_contrato')
        // ->where('sms_contrato.id_proveedor', '=', $id_proveedor)
        // ->join('sms_materia_prima_esencias','sms_det_contrato.cod_mp_esencia','=','sms_materia_prima_esencias.codigo')
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
        //     'sms_contrato.exclusividad'
        // )
        // ->distinct()
        // ->get();

        // $productos_disponibles = null;
        //
        // if (empty($productos_contratados) != false){
        //     foreach ($productos_contratados as $producto_contratado){
        //         if ($productos->where($productos->codigo = $producto_contratado->codigo)->exists()){
        //             if ($producto->codigo == $producto_contratado->codigo){
        //                 if ($producto_contratado->exclusividad == false){
        //                     array_push($productos_disponibles, $producto_contratado);
        //                 }
        //             }
        //         }else{
        //
        //             array_push($productos_disponibles, $producto_contratado);
        //         }
        //     }
        // }else{
        //     $productos_disponibles = $productos;
        // }



        $productos_disponibles = self::getProductosDisponibles($id_proveedor);
         $otras_materias_disponibles = self::getMateriasPrimasDisponibles($id_proveedor);
         $condiciones_pago = self::getCondicionesPago($id_proveedor);
         $condiciones_envio = self::getCondicionesEnvio($id_productor, $id_proveedor);

        return view('evaluación/evaluacionGeneracionContrato', [
            'productor' => $productor,
            'proveedor' => $proveedor,
            'productos' => $productos_disponibles,
            'ingredientes_otros' => $otras_materias_disponibles,
            'condiciones_pago' => $condiciones_pago,
            'condiciones_envio' => $condiciones_envio,
        ]);
    }
}

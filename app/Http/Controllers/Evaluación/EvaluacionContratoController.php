<?php

namespace App\Http\Controllers\Evaluación;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Productor;
use App\Proveedor;
use App\Variable;
use App\EvaluacionResultado;


class EvaluacionContratoController extends Controller
{

    public function getEscala($id_productor){
        $escala = DB::table('sms_escala')
        ->where(
            'sms_escala.id_productor','=',$id_productor,
            'sms_escala.fecha_final','=',null
        );
        var_dump($escala);
        return $escala;
    }



    function getFormulaInicial($id_productor){
        $formula_final = DB::table('sms_eval_criterio')
        ->join('sms_escala','sms_eval_criterio.id_productor','=', 'sms_escala.id_productor')
        ->where('sms_eval_criterio.id_productor','=',$id_productor)
        ->where('sms_escala.id_productor','=',$id_productor)
        ->where('sms_eval_criterio.fecha_final','=',null)
        ->where('sms_escala.fecha_final','=',null)
        ->where('sms_eval_criterio.tipo_formula','=','i')
        ->join('sms_variable','sms_eval_criterio.id_variable','=','sms_variable.id')
        ->select(
            'sms_eval_criterio.id_variable',
            'sms_eval_criterio.peso',
            'sms_escala.rango_inicial',
            'sms_escala.rango_final',
            'sms_variable.id'
        )
        ->distinct()
        ->get();

        return $formula_final;
    }

    public function evaluar($id_productor, $id_proveedor, Request $request){

        $productor = Productor::findOrFail($id_productor);
        $proveedor = Proveedor::findOrFail($id_proveedor);
        $formula_inicial = self::getFormulaInicial($id_productor);

        // $formula_inicial = DB::table('sms_eval_criterio')
        // ->join('sms_escala','sms_eval_criterio.id_productor','=', 'sms_eval_criterio.id_productor')
        // ->where('sms_eval_criterio.id_productor','=',$id_productor)
        // ->where('sms_eval_criterio.fecha_final','=',null)
        // ->where('sms_eval_criterio.tipo_formula','=','i')
        // ->where('sms_escala.fecha_final','=',null)
        // ->select(
        //     'sms_eval_criterio.id_variable',
        //     'sms_eval_criterio.peso',
        //     'sms_escala.rango_inicial',
        //     'sms_escala.rango_final',
        // )
        // ->get();

        foreach ($formula_inicial as $variable){
            if (($request->input($variable->id_variable) > {{$variable->rango_inicial}}) || ($request->input($variable->id_variable) < $variable->rango_final)){
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

        return view('evaluación/evaluacionResultado', [
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

         $otras_materias_disponibles = DB::table('sms_componente_ing_otros')
         ->join('sms_presentacion_mp', 'sms_componente_ing_otros.codigo','=','sms_presentacion_mp.cod_componente_ing')
         ->where('sms_componente_ing_otros.id_proveedor','=',$id_proveedor)
         ->select(
             'sms_componente_ing_otros.codigo',
             'sms_componente_ing_otros.nombre',
             'sms_componente_ing_otros.ipc AS num_ipc',
             'sms_componente_ing_otros.tsca_cas AS num_tsca_cas',
             'sms_presentacion_mp.precio',
             'sms_presentacion_mp.volml'
         )
         ->whereNotExists(function ($query) {
              $query->select(DB::raw(1))
                  ->from('sms_det_contrato')
                  ->join('sms_contrato', 'sms_det_contrato.cod_contrato','=','sms_contrato.codigo')
                  ->whereRaw('sms_det_contrato.cod_componente_ing = sms_componente_ing_otros.codigo AND sms_contrato.exclusividad = true');

         })
          ->get();

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

        //$escala = self::getEscala($id_productor);
        $formula_inicial = self::getFormulaInicial($id_productor);

        return view('evaluación/evaluacionContrato', [
            'productor' => $productor,
            'proveedor' => $proveedor,
            'id_proveedor' => $id_proveedor,
            'productos' => $productos_disponibles,
            'ingredientes_otros' => $otras_materias_disponibles,
            'condiciones_pago' => $condiciones_pago,
            'condiciones_envio' => $condiciones_envio,
            'variables' => $variables,
            'formula_inicial' => $formula_inicial[0]
            //'escala' => $escala
        ]);
    }
}

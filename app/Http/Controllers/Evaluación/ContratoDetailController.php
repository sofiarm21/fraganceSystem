<?php

namespace App\Http\Controllers\Evaluación;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\EvaluacionResultado;
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
                'sms_contrato.fecha',
            )
        ->distinct()
        ->get();

        return $contratos;
    }

    function getContrato($cod_contrato){
        $contrato = DB::table('sms_contrato')
        ->leftJoin('sms_renueva','sms_renueva.cod_contrato','=','sms_contrato.codigo')
        ->where('sms_contrato.codigo','=',$cod_contrato)
        ->select(
                'sms_proveedores.nombre',
                'sms_contrato.fecha',
                'sms_renueva.fecha AS fecha_renueva'
            )
        ->distinct()
        ->get();

        return $contrato;

    }

    function getVariablesFinales(){
        $variables = DB::table('sms_variable')
        ->select(
            'nombre',
            'descripcion',
            'id'
        )
        ->where('tipo','=','f')
        ->get();

        return $variables;
    }

    // function getEscala($id_productor){
    //     $escala = DB::table('sms_escala')
    //     ->select('sms_escala.rango_inicial', 'sms_escala.rango_final')
    //     ->from('sms_escala')
    //     ->where('sms_escala.id_productor','=',$id)
    //     ->where('sms_escala.fecha_final','=',null)
    //     ->get()
    //     ->values([0]);
    //
    //     return $escala;
    // }

    function getFormulaFinal($id_productor){
        $formula_final = DB::table('sms_eval_criterio')
        ->join('sms_escala','sms_eval_criterio.id_productor','=', 'sms_escala.id_productor')
        ->where('sms_eval_criterio.id_productor','=',$id_productor)
        ->where('sms_escala.id_productor','=',$id_productor)
        ->where('sms_eval_criterio.fecha_final','=',null)
        ->where('sms_escala.fecha_final','=',null)
        ->where('sms_eval_criterio.tipo_formula','=','f')
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


    public function evaluarFinal($id_productor, $id_proveedor, $codigo_contrato, Request $request){

        $productor = Productor::findOrFail($id_productor);
        $proveedor = Proveedor::findOrFail($id_proveedor);
        $formula_final = self::getFormulaFinal($id_productor);
        $variables = self::getVariablesFinales();

        var_dump($formula_final);

        foreach ($formula_final as $variable){


            if (($request->input($variable->id) > $variable->rango_final) || ($request->input($variable->id) < $variable->rango_inicial)){
                return back()->withInput();
            }
        }

        $evaluacion_resultado = new EvaluacionResultado();
        $evaluacion_resultado->id_productor=$id_productor;
        $evaluacion_resultado->id_proveedor=$id_proveedor;
        $evaluacion_resultado->fecha_realizada = date('Y-m-d H:i:s');
        $evaluacion_resultado->tipo_eval = 'f';

        $suma = 0;
        foreach ($formula_final as $variable){
            $suma += $request->input($variable->id) * ($variable->peso / 100);
        }

        $evaluacion_resultado->resultado = $suma;
        $evaluacion_resultado->save();

        $aprobado = false;
        if ($evaluacion_resultado->resultado > $formula_final[0]->rango_final * 0.8){
            $aprobado = true;
        }


        return view('evaluación/evaluacionFinalResultado', [
            'productor' => $productor,
            'proveedor' => $proveedor,
            'aprobado' => $aprobado,
            'resultado' => $evaluacion_resultado->resultado,
            'cod_contrato' => $codigo_contrato
        ]);

    }




    public function view($id_productor, $id_proveedor, $codigo_contrato){

        $productor = Productor::findOrFail($id_productor);
        $proveedor = Proveedor::findOrFail($id_proveedor);
        $contrato = Contrato::findOrFail($codigo_contrato);
        $variables = self::getVariablesFinales();
        $formula_final=self::getFormulaFinal($id_productor);
        //$escala = self::getEscala($id_productor);


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
            'variables' => $variables,
            'formula_final'=>$formula_final[0]

        ]);
    }

}

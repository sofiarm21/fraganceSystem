<?php

namespace App\Http\Controllers\Evaluación;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\Productor;
use App\Variable;
use App\EvaluacionCriterio;


class FormulaFinalController extends Controller
{

    public function getVariables(){
        $variables = DB::table('sms_variable')
        ->where('sms_variable.tipo','=','f')
        ->get();

        return $variables;
    }


    public function getEscala($id){
        $escala = DB::table('sms_escala')
        ->select('sms_escala.rango_inicial', 'sms_escala.rango_final')
        ->from('sms_escala')
        ->where('sms_escala.id_productor','=',$id)
        ->where('sms_escala.fecha_final','=',null)
        ->get();

        return $escala;
    }

    public function create($id, Request $request){

        $productor = Productor::findOrFail($id);
        $variables = self::getVariables();
        $sum = 0;
        $escala = self::getEscala($id);


        foreach ($variables as $variable){
            if ($request->input($variable->id) == null){
                return view('evaluación/formulaFinal', [
                    'productor' => $productor,
                    'variables' => $variables,
                    'escala' => $escala,
                    'errorMessage' => 'Debe llenar todos los campos'
                ]);
            }
            else if ($request->input($variable->id) > 100){
                return view('evaluación/formulaFinal', [
                    'productor' => $productor,
                    'variables' => $variables,
                    'escala' => $escala,
                    'errorMessage' => 'El porcentaje no debe sobrepasar a 100%'
                ]);
            }
            else if ($request->input($variable->id) < 0){
                return view('evaluación/formulaFinal', [
                    'productor' => $productor,
                    'variables' => $variables,
                    'escala' => $escala,
                    'errorMessage' => 'El porcentaje no debe estar por debajo de 0%a'
                ]);
            }
            $sum += $request->input($variable->id);
        }

        if ($sum <> 100){
            return view('evaluación/formulaFinal', [
                'productor' => $productor,
                'variables' => $variables,
                'escala' => $escala,
                'errorMessage' => 'La suma de los porcentajes debe dar 100%'
            ]);

        }



        DB::table('sms_eval_criterio')
            -> where('fecha_final', null)
            -> where('id_productor', $id)
            -> where('tipo_formula', 'f')
            ->update(['fecha_final' => date('Y-m-d H:i:s')]);


        foreach ($variables as $variable){

            $criterio = new EvaluacionCriterio();

            $criterio->id_productor = $id;
            $criterio->id_variable = DB::table('sms_variable')
                ->select('sms_variable.id')
                ->from('sms_variable')
                ->where('sms_variable.nombre','=',$variable->nombre)
                ->where('sms_variable.tipo','=','f')
                ->value([0]);
            $criterio->fecha_inicial = date('Y-m-d H:i:s');
            $criterio->peso = $request->input($variable->id);
            $criterio->tipo_formula = 'f';

            $criterio->save();

        }

        return redirect()->action('Evaluación\EvaluacionDetailController@view', ['id' => $id]);


    }

    public function view($id){

        $productor = Productor::findOrFail($id);
        $variables = self::getVariables();

        $escala = self::getEscala($id);


        return view('evaluación/formulaFinal', [
            'productor' => $productor,
            'variables' => $variables,
            'escala' => $escala,
            'errorMessage' => null
        ]);
    }
}

<?php

namespace App\Http\Controllers\Evaluación;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Redirector;

use App\Productor;
use App\Variable;
use App\EvaluacionCriterio;

class FormulaInicialController extends Controller
{


    public function create($id, Request $request){

        $productor = Productor::findOrFail($id);
        $variables = DB::table('sms_variable')
        ->where('sms_variable.tipo','=','i')
        ->get();
        $sum = 0;
        $escala = DB::table('sms_escala')
        ->select('sms_escala.rango_inicial', 'sms_escala.rango_final')
        ->from('sms_escala')
        ->where('sms_escala.id_productor','=',$id)
        ->where('sms_escala.fecha_final','=',null)
        ->get();

        foreach ($variables as $variable){
            if ($request->input($variable->id) == null){
                return view('evaluación/formulaInicial', [
                    'productor' => $productor,
                    'variables' => $variables,
                    'escala' => $escala,
                    'errorMessage' => 'Debe llenar todos los campos'
                ]);
            }
            else if ($request->input($variable->id) > $escala[0]->rango_final){
                return view('evaluación/formulaInicial', [
                    'productor' => $productor,
                    'variables' => $variables,
                    'escala' => $escala,
                    'errorMessage' => 'El porcentaje no debe sobrepasar a la escala'
                ]);
            }
            else if ($request->input($variable->id) < $escala[0]->rango_inicial){
                return view('evaluación/formulaInicial', [
                    'productor' => $productor,
                    'variables' => $variables,
                    'escala' => $escala,
                    'errorMessage' => 'El porcentaje no debe estar por debajo de la escala'
                ]);
            }
            $sum += $request->input($variable->id);
        }

        if ($sum <> $escala[0]->rango_final){
            return view('evaluación/formulaInicial', [
                'productor' => $productor,
                'variables' => $variables,
                'escala' => $escala,
                'errorMessage' => 'La suma de los porcentajes no es válida'
            ]);

        }


        DB::table('sms_eval_criterio')
            -> where('fecha_final', null)
            -> where('id_productor', $id)
            -> where('tipo_formula', 'i')
            ->update(['fecha_final' => date('Y-m-d H:i:s')]);


        foreach ($variables as $variable){

            $criterio = new EvaluacionCriterio();

            $criterio->id_productor = $id;
            $criterio->id_variable = DB::table('sms_variable')
                ->select('sms_variable.id')
                ->from('sms_variable')
                ->where('sms_variable.nombre','=',$variable->nombre)
                ->where('sms_variable.tipo','=','i')
                ->value([0]);
            $criterio->fecha_inicial = date('Y-m-d H:i:s');
            $criterio->peso = $request->input($variable->id);
            $criterio->tipo_formula = 'i';

            $criterio->save();

        }

        return redirect()->action('Evaluación\EvaluacionDetailController@view', ['id' => $id]);



        //$criterio->id_variable = $request->input('nombre');


        // $libro->año = $request->input('año');
        // $libro->autor = $request->input('autor');
        // $libro->resumen = $request->input('resumen');
        //$categoria_libro->id_categoria = $request->input('categoria')
        //$libro->id_editorial = $request->input('editorial');
        // echo($request->input('editorial'));
        // $criterio->id_criterio = DB::table('sms_variable')
        //     ->select('sms_variable.id')
        //     ->from('sms_variable')
        //     ->where('sms_variable.nombre','=',$request->input('editorial'))
        //     ->value([0]);
        //
        //
        //
        //
        //
        // $libro->id_editorial = DB::table('editorial')
        //     ->select('editorial.id')
        //     ->from('editorial')
        //     ->where('editorial.nombre','=',$request->input('editorial'))
        //     ->value([0]);
        //
        // echo($request->input('categoria'));
        // $libro->save();
        //
        // $id_categoria = DB::table('categorias')
        // ->select('categorias.id')
        // ->from('categorias')
        // ->where('categorias.nombre','=',$request->input('categoria'))
        // ->value([0]);
        //
        // $id_libro = DB::table('libros')
        // ->select('libros.id')
        // ->from('libros')
        // ->where('libros.nombre','=',$request->input('nombre'))
        // ->value([0]);
        //
        // DB::table('categoria_libro')->insert(
        //     ['id_categoria' => $id_categoria,
        //     'id_libro' => $id_libro]
        // );

        // SELECT editorial.id
        // FROM editorial
        // WHERE editorial.nombre = :nombre_editorial
        // ',[':nombre_editorial'=>$request->input('editorial')]);


    }

    public function view($id){

        $productor = Productor::findOrFail($id);
        $variables = DB::table('sms_variable')
        ->where('sms_variable.tipo','=','i')
        ->get();
        $escala = DB::table('sms_escala')
        ->select('sms_escala.rango_inicial', 'sms_escala.rango_final')
        ->from('sms_escala')
        ->where('sms_escala.id_productor','=',$id)
        ->where('sms_escala.fecha_final','=',null)
        ->get();



        return view('evaluación/formulaInicial', [
            'productor' => $productor,
            'variables' => $variables,
            'escala' => $escala,
            'errorMessage' => null
        ]);
    }
}

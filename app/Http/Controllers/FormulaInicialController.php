<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Redirector;

use App\Productor;
use App\Variable;
use App\EvaluacionCriterio;

class FormulaInicialController extends Controller
{


    public function create($id, Request $request){

        $productor = Productor::findOrFail($id);
        $variables = Variable::all();
        $sum = 0;


        foreach ($variables as $variable){
            if ($request->input($variable->id) == null){
                return view('formulaInicial', [
                    'productor' => $productor,
                    'variables' => $variables,
                    'errorMessage' => 'Debe llenar todos los campos'
                ]);
            }
            $sum += $request->input($variable->id);
        }

        if ($sum <> 100){
            return view('formulaInicial', [
                'productor' => $productor,
                'variables' => $variables,
                'errorMessage' => 'La suma de los porcentajes no es válida'
            ]);

        }


        DB::table('sms_eval_criterio')
            -> where('fecha_final', null)
            -> where('id_productor', $id)
            ->update(['fecha_final' => date('Y-m-d H:i:s')]);


        foreach ($variables as $variable){

            $criterio = new EvaluacionCriterio();

            $criterio->id_productor = $id;
            $criterio->id_variable = DB::table('sms_variable')
                ->select('sms_variable.id')
                ->from('sms_variable')
                ->where('sms_variable.nombre','=',$variable->nombre)
                ->value([0]);
            $criterio->fecha_inicial = date('Y-m-d H:i:s');
            $criterio->peso = $request->input($variable->id);
            $criterio->tipo_formula = 'i';

            $criterio->save();

        }

        return redirect()->action('EvaluacionDetailController@view', ['id' => $id]);



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
        $variables = Variable::all();

        return view('formulaInicial', [
            'productor' => $productor,
            'variables' => $variables,
            'errorMessage' => null
        ]);
    }
}

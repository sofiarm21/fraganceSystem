<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Productor;
use App\Variable;
use App\EvaluacionCriterio;

class FormulaInicialController extends Controller
{


    public function create($id, Request $request){
        $variables = Variable::all();
        echo ($id);

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


            echo ($criterio);
            $criterio->save();

        }

        return redirect('/Evaluacion');



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
            'variables' => $variables
        ]);
    }
}

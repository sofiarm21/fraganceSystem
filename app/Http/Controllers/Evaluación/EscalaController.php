<?php

namespace App\Http\Controllers\Evaluación;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Escala;
use App\Productor;

class EscalaController extends Controller
{

    public function create($id, Request $request){

        $productor = Productor::findOrFail($id);

        if ($request->input('rango_inicial') == null  OR $request->input('rango_final') == null){
            return view('escala', [
                'productor' => $productor,
                'errorMessage' => 'Debe llenar todos los campos'
            ]);
        }
        else if ($request->input('rango_inicial') > $request->input('rango_final')){
            return view('escala', [
                'productor' => $productor,
                'errorMessage' => 'El rango inicial debe ser menor que el rango final'
            ]);
        }
        else if ($request->input('rango_inicial') == $request->input('rango_final')){
            return view('escala', [
                'productor' => $productor,
                'errorMessage' => 'El rango inicial debe ser distinto al rango final'
            ]);
        }

        DB::table('sms_escala')
            -> where('fecha_final', null)
            -> where('id_productor', $id)
            ->update(['fecha_final' => date('Y-m-d H:i:s')]);

        $escala = new Escala();

        $escala->id_productor = $id;
        $escala->fecha_inicial = date('Y-m-d H:i:s');
        $escala->rango_inicial = $request->input('rango_inicial');
        $escala->rango_final = $request->input('rango_final');

        $escala->save();


        return redirect()->action('EvaluacionDetailController@view', ['id' => $id]);



    }

    public function view($id){

        $productor = Productor::findOrFail($id);


        return view('escala', [
            'productor' => $productor,
            'errorMessage' => null,
        ]);
    }
}

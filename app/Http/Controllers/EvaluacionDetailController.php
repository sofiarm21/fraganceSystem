<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Productor;
use App\Escala;

class EvaluacionDetailController extends Controller
{
    public function view($id){

        $productor = Productor::findOrFail($id);
        //$escala = Escala::find($id);
        $escala = DB::table('sms_escala')
        ->select('sms_escala.rango_inicial, sms_escala.rango_final ')
        ->from('sms_escala')
        ->where('sms_escala.id_proveedeor','=',$id)
        ->where('sms_escala.fecha_final','=',null);
        //
        // $criterio->id_criterio = DB::table('sms_variable')
        //     ->select('sms_variable.id')
        //     ->from('sms_variable')
        //     ->where('sms_variable.nombre','=',$request->input('editorial'))
        //     ->value([0]);
        //

        return view('evaluacionDetail', [
            'productor' => $productor,
            'escala' => $escala
        ]);
    }
}

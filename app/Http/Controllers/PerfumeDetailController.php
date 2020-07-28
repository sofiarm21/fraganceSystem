<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Perfume;
use Illuminate\Support\Facades\DB;

class PerfumeDetailController extends Controller
{
  public function getPerfume($codigo){
    $perf = DB::table('sms_perfume')
    ->select('codigo','nombre','id_productor','genero','edad','tipo')
    ->where('sms_perfume.codigo','=',$codigo)
    ->get();
    return $perf;
  }
  public function getProductor($id_productor){
    $prod = DB::table('sms_productores')
    ->select('id','nombre')
    ->where('sms_productores.id','=',$id_productor)
    ->get();
    return $prod;
  }

  public function getPerfumistas($codigo){
    $prod = DB::table('sms_p_p')
    ->join('sms_perfumista','sms_perfumista.id','=','sms_p_p.id_perfumista')
    ->select('sms_perfumista.nombre','sms_perfumista.apellido')
    ->where('sms_p_p.cod_perfume','=',$codigo)
    ->get();
    return $prod;
  }

  public function getIntensidad($id_productor){
    $prod = DB::table('sms_productores')
    ->select('id','nombre')
    ->where('sms_productores.id','=',$id_productor)
    ->get();
    return $prod;
  }

  public function getIngredientes($codigo){
    $x = DB::table('sms_otros_ingr')
    ->join('sms_componente_ing_otros','sms_componente_ing_otros.codigo','=','sms_otros_ingr.cod_comp_ing_otros')
    ->select('sms_componente_ing_otros.codigo','sms_componente_ing_otros.tsca_cas','sms_componente_ing_otros.nombre')
    ->where('sms_otros_ingr.cod_perfume','=',$codigo)
    ->get();
    return $x;
  }

  public function getPresentciones($codigo){
    $x = DB::table('sms_presentacion_perfume')
    ->select('volml')
    ->where('sms_presentacion_perfume.cod_perfume','=',$codigo)
    ->get();
    return $x;
  }

  public function getNotas($codigo, $tipo){
    $x = DB::table('sms_nota')
    ->join('sms_esencia_perfume','sms_nota.tsca_cas_esencia','=','sms_esencia_perfume.tsca_cas')
    ->select('sms_esencia_perfume.nombre')
    ->where('sms_nota.cod_perfume_por_fases','=',$codigo)
    ->where('sms_nota.tipo','=',$tipo)
    ->get();
    return $x;
  }

  public function index($codigo){

      $perfume=self::getPerfume($codigo);
      $perfume=$perfume[0];
      $productor=self::getProductor($perfume->id_productor);
      $productor=$productor[0];
      $perfumistas=self::getPerfumistas($codigo);
      $ingredientes=self::getIngredientes($codigo);
      $presentaciones=self::getPresentciones($codigo);
      $notass=self::getNotas($codigo,"s");
      $notasc=self::getNotas($codigo,"c");
      $notasf=self::getNotas($codigo,"f");
      

      return view('perfumeDetail', [
          'perfume' => $perfume,
          'productor' => $productor,
          'perfumistas' => $perfumistas,
          'ingredientes' => $ingredientes,
          'presentaciones' => $presentaciones,
          'notass'=> $notass,
          'notasc'=> $notasc,
          'notasf'=> $notasf

      ]);
  }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecomendadorController extends Controller
{

    public function recommend(Request $request){

      $genero = $request["genero"];
      $edad = $request["edad"];
      $intensidad = $request["intensidad"];
      $uso = $request["uso"];
      $caracteres = $request["caracter_id"];
      $familias_olfativas = $request["familia_codigo"];
      $aromas = $request["aroma_codigo"];
      $personalidades = $request["personalidad_codigo"];

      if ($genero=="N" and $edad=='N' and $intensidad=="0" and $uso=='0' and $caracteres==null and $familias_olfativas==null and $aromas==null and $personalidades==null){
          return view('recomendador', [
              'resultMessage' => 'DEBE LLENAR AL MENOS UN CAMPO',
              'familias_olfativas' => self::getFamiliasOlfativas(),
              'caracteres' => self::getCaracteres(),
              'aromas'=> self::getAromas(),
              'personalidades'=> self::getPersonalidades()
            ]);
      }

      $max_resultado = 0;
      $perfumesPuntaje = self::getPerfumesPuntaje();

      // FILTROS
      if ($genero != "N"){
          foreach ($perfumesPuntaje as $p) {
              if($p->genero == $genero)
              $p->puntaje = $p->puntaje + 1;
          }
          $max_resultado++;
      }

      if ($edad != "N"){
          foreach ($perfumesPuntaje as $p) {
              if($p->edad == $edad)
              $p->puntaje = $p->puntaje + 1;
          }
          $max_resultado++;
      }


      if ($intensidad != "0"){
          foreach ($perfumesPuntaje as $p) {
              if($intensidad == "1"){
                $flag = DB::table('sms_intensidad')
                ->select('sms_intensidad.id')
                ->where('cod_perfume','=',$p->codigo)
                ->where(function ($query){
                  $query->where('tipo','=', "EdC")
                        ->orwhere('tipo','=', "EdS");
                })
                ->get();
              }
              elseif ($intensidad == "2") {
                $flag = DB::table('sms_intensidad')
                ->select('sms_intensidad.id')
                ->where('cod_perfume','=',$p->codigo)
                ->where('tipo','=',"EdT")
                ->get();
              }
              elseif ($intensidad == "3") {
                $flag = DB::table('sms_intensidad')
                ->select('sms_intensidad.id')
                ->where('cod_perfume','=',$p->codigo)
                ->where(function ($query){
                  $query->where('tipo','=', "EdP")
                        ->orwhere('tipo','=', "P");
                })
                ->get();
              }

              if(count($flag) != 0){
              $p->puntaje = $p->puntaje + 1;
            }
          }
          $max_resultado++;
      }

      if ($uso != "0"){
          foreach ($perfumesPuntaje as $p) {
              if($uso == "1"){
                $flag = DB::table('sms_intensidad')
                ->select('sms_intensidad.id')
                ->where('cod_perfume','=',$p->codigo)
                ->where(function ($query){
                  $query->where('tipo','=', "EdT")
                        ->orwhere('tipo','=', "EdP")
                        ->orwhere('tipo','=', "EdS");
                })
                ->get();
              }
              elseif ($uso == "2") {
                $flag = DB::table('sms_intensidad')
                ->select('sms_intensidad.id')
                ->where('cod_perfume','=',$p->codigo)
                ->where('tipo','=',"EdC")
                ->get();
              }
              elseif ($uso == "3") {
                $flag = DB::table('sms_intensidad')
                ->select('sms_intensidad.id')
                ->where('cod_perfume','=',$p->codigo)
                ->where('tipo','=',"P")
                ->get();
              }

              if(count($flag) != 0){
              $p->puntaje = $p->puntaje + 1;
            }
          }
          $max_resultado++;
      }


      if($familias_olfativas!=null){
        foreach ($familias_olfativas as $f) {
           foreach ($perfumesPuntaje as $p) {
             $flag = DB::table('sms_principal_f_p')
             ->where('sms_principal_f_p.cod_perfume','=',$p->codigo)
             ->where('sms_principal_f_p.cod_familia_olfativa','=',$f)
             ->get();
             if(count($flag)!=0){
               $p->puntaje = $p->puntaje + 1;
             }
           }
           $max_resultado++;
        }
      }

      if($caracteres!=null){
        foreach ($caracteres as $c) {
           foreach ($perfumesPuntaje as $p) {
             $flag = DB::table('sms_folf')
             ->join('sms_principal_f_p','sms_principal_f_p.cod_familia_olfativa','=','sms_folf.cod_familia_olfativa')
             ->where('sms_principal_f_p.cod_perfume','=',$p->codigo)
             ->where('sms_folf.id_palabra_clave','=',$c)
             ->where('sms_folf.tipo','=',"caracter")
             ->get();
             if(count($flag)!=0){
               $p->puntaje = $p->puntaje + 1;
             }
           }
           $max_resultado++;
        }
      }

      if($aromas!=null){
        foreach ($aromas as $a) {
           foreach ($perfumesPuntaje as $p) {
             $flag = DB::table('sms_folf')
             ->join('sms_principal_f_p','sms_principal_f_p.cod_familia_olfativa','=','sms_folf.cod_familia_olfativa')
             ->where('sms_principal_f_p.cod_perfume','=',$p->codigo)
             ->where('sms_folf.id_palabra_clave','=',$a)
             ->where('sms_folf.tipo','=',"aroma")
             ->get();
             if(count($flag)!=0){
               $p->puntaje = $p->puntaje + 1;
             }
           }
           $max_resultado++;
        }
      }

      if($personalidades!=null){
        foreach ($personalidades as $per) {
           foreach ($perfumesPuntaje as $p) {
             $flag = DB::table('sms_folf')
             ->join('sms_principal_f_p','sms_principal_f_p.cod_familia_olfativa','=','sms_folf.cod_familia_olfativa')
             ->where('sms_principal_f_p.cod_perfume','=',$p->codigo)
             ->where('sms_folf.id_palabra_clave','=',$per)
             ->where('sms_folf.tipo','=',"personalidad")
             ->get();
             if(count($flag)!=0){
               $p->puntaje = $p->puntaje + 1;
             }
           }
           $max_resultado++;
        }
      }

      //SE OBTIENE EL MAYOR PUNTAJE
      $mayor=0;
      foreach ($perfumesPuntaje as $p) {
        if($p->puntaje > $mayor){
          $mayor = $p->puntaje;
        }
      };
      //$resultado = array();
      //$i=0;
      //foreach ($perfumesPuntaje as $p) {
        //if($p->puntaje == $mayor){
          //$resultado[$i]=$p->codigo;
          //$i ++;
        //}
      //}


      //dd(array($perfumesPuntaje), $max_resultado, $familias_olfativas, DB::select('select * from sms_perfume where codigo=1 or codigo=3'));

      return view('recomendadorResultado', [
        'resultMessage' => 'BIENN',
        'mayor' => $mayor,
        'max_resultado' => $max_resultado,
        'perfumes'=> $perfumesPuntaje

      ]);
    }



    public function getFamiliasOlfativas(){
        $familias_olfativas = DB::table('sms_familia_olfativa')
        ->select(
          'sms_familia_olfativa.codigo',
          'sms_familia_olfativa.nombre',
          'sms_familia_olfativa.descripcion'
          )
        ->get();
        return $familias_olfativas;
    }


    public function getPalabrasClave(){
        $palabras_clave = DB::table('sms_palabra_clave')
        ->select(
          'sms_palabra_clave.id',
          'sms_palabra_clave.palabra',
          )
        ->get();
        return $palabras_clave;
    }

    public function getPerfumesPuntaje(){
        $perf = DB::table('sms_perfume')
        ->select(DB::raw('codigo, 0 as puntaje, genero, edad, nombre'))
        ->get();
        return $perf;
    }

    public function getCaracteres(){
        $car = DB::table('sms_palabra_clave')
        ->join('sms_folf','sms_palabra_clave.id','=','sms_folf.id_palabra_clave')
        ->select('sms_palabra_clave.id','sms_palabra_clave.palabra')
        ->where('sms_folf.tipo','=',"caracter")
        ->distinct()
        ->get();
        return $car;
    }

    public function getAromas(){
        $aro = DB::table('sms_palabra_clave')
        ->join('sms_folf','sms_palabra_clave.id','=','sms_folf.id_palabra_clave')
        ->select('sms_palabra_clave.id','sms_palabra_clave.palabra')
        ->where('sms_folf.tipo','=',"aroma")
        ->distinct()
        ->get();
        return $aro;
    }

    public function getPersonalidades(){
        $aro = DB::table('sms_palabra_clave')
        ->join('sms_folf','sms_palabra_clave.id','=','sms_folf.id_palabra_clave')
        ->select('sms_palabra_clave.id','sms_palabra_clave.palabra')
        ->where('sms_folf.tipo','=',"personalidad")
        ->distinct()
        ->get();
        return $aro;
    }

    public function index(){

        return view('recomendador', [
          'resultMessage' => null,
          'familias_olfativas' => self::getFamiliasOlfativas(),
          'caracteres' => self::getCaracteres(),
          'aromas'=> self::getAromas(),
          'personalidades'=> self::getPersonalidades()

        ]);
    }
}

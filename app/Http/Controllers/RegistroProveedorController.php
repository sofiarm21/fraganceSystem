<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Proveedor;

class RegistroProveedorController extends Controller
{
    public function view($id){


        //$proveedores = Proveedor::where

        // $proveedores = DB::table('sms_hist_membresia_ifra')
        // ->select('sms_hist_membresia_ifra.id_proveedor')
        // ->from('sms_hist_membresia_ifra')
        // ->where('sms_hist_membresia_ifra.fecha_fin','=',null)
        // ->get()
        // ->values([0]);

        // $proveedores = DB::table('sms_proveedores')
        // ->join('sms_hist_membresia_ifra','sms_hist_membresia_ifra.fecha_fin','=','fechaFin')
        // ->where('fechaFin','=',null)
        // ->select('sms_proveedores.id')
        // ->get();

        // $categoria=DB::table('libros')
        //    ->join('categoria_libro','categoria_libro.id_libro','=','libros.id')
        //    ->where('libros.id','=',$libro->id)
        //    ->join('categorias','categoria_libro.id_categoria','=','categorias.id')
        //    ->select('categorias.nombre')
        //    ->distinct()
        //    ->get();

        // $proveedores=DB::table('sms_proveedor')
        // ->select('sms_proveedor.id')
        // ->from('sms_proveedor')
        // ->where('sms_hist_membresia_ifra.fecha_fin','=',null)
        //
        //
        //
        //    ->join('sms_hist_membresia_ifra','sms_hist_membresia_ifra.id_proveedor','=','sms_proveedor.id')
        //    ->where('sms_proveedor.id','=',$libro->id)
        //    ->join('categorias','categoria_libro.id_categoria','=','categorias.id')
        //    ->select('categorias.nombre')
        //    ->distinct()
        //    ->get();

        // $proveedores=DB::table('sms_proveedores')
        //     ->join('sms_hist_membresia_ifra','sms_hist_membresia_ifra.id_proveedor','=','sms_proveedores.id')
        //     ->where('sms_hist_membresia_ifra.fecha_fin','=',null)
        //     ->join('sms_proveedores','sms_proveedores.cod_pais','=','sms_p_pais.cod_pais')
        //     ->where('sms_p_pais.id_productor','=',$id)
        //
        //
        //    // ->join('sms_p_pais','sms_p_pais.id_productor','=','sms_productores.id')
        //    // ->where('sms_productores.id','=',$id)
        //    // ->where('sms_p_pais.cod_pais','=','ssms_proveedores.cod_pai')
        //    // ->select('sms_proveedores.id', 'sms_hist_membresia_ifra.fecha_fin', 'sms_p_pais.cod_pais')
        //    ->distinct()
        //    ->get();


           $proveedoresDisponibles=DB::table('sms_hist_membresia_ifra')
               ->join('sms_proveedores','sms_proveedores.id','=','sms_hist_membresia_ifra.id_proveedor')
               ->where('sms_hist_membresia_ifra.fecha_fin','=',null)
               ->join('sms_envio','sms_proveedores.id','=','sms_envio.id_proveedor')
               ->join('sms_p_pais','sms_envio.cod_pais','=','sms_p_pais.cod_pais')
               ->where('sms_p_pais.id_productor','=',$id)
               ->join('sms_paises','sms_p_pais.cod_pais','=','sms_paises.codigo')
               ->select('sms_proveedores.id AS proveedor_id','sms_proveedores.nombre AS proveedor_nombre', 'sms_p_pais.cod_pais','sms_paises.nombre AS pais_nombre', 'sms_envio.tipo_transporte AS tipo_envio', 'sms_envio.costo AS costo_envio')

               // ->join('sms_p_pais','sms_proveedores.cod_pais','=','sms_p_pais.cod_pais')
               // ->where('sms_p_pais.id_productor','=',$id)
               // ->select('sms_proveedores.id', 'sms_hist_membresia_ifra.fecha_fin', 'sms_p_pais.cod_pais')


              // ->join('sms_p_pais','sms_p_pais.id_productor','=','sms_productores.id')
              // ->where('sms_productores.id','=',$id)
              // ->where('sms_p_pais.cod_pais','=','ssms_proveedores.cod_pai')
              // ->select('sms_proveedores.id', 'sms_hist_membresia_ifra.fecha_fin', 'sms_p_pais.cod_pais')
              ->distinct()
              ->get();

        return view('evaluacionRegistroProveedor', [
            'proveedores' => $proveedoresDisponibles,
            'productor_id' => $id
        ]);
    }
}

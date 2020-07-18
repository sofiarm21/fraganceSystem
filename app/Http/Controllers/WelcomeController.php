<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(){

        // $categorias = Categoria::all();
        // $libros = Libro::all();
        // $editoriales = Editorial::all();
        // foreach ($libros as $libro) {
        //     echo $libro->nombre;
        // }die;


        return view('welcome', [
            // 'libros' => $libros,
            // 'categorias' => $categorias,
            // 'editoriales' => $editoriales
        ]);
    }
}

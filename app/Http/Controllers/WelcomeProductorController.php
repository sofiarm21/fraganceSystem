<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Productor;

class WelcomeProductorController extends Controller
{
    public function index(){

        $productores = Productor::all();

        return view('welcomeProductor', [
            'productores' => $productores,
        ]);
    }
}

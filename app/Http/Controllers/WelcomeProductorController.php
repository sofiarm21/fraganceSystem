<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeProductorController extends Controller
{
    public function index(){



        return view('welcomeProductor', [
            
        ]);
    }
}

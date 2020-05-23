<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Condiciones extends Controller{

    //Funcio per mostrar la vista de Condicions
    public function index(){
        return view('Condiciones');
    }
}

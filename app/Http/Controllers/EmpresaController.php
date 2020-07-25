<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmpresaController extends Controller
{

    public function index(){
        return view("Empresas.empresas_dashboard");
    }
}

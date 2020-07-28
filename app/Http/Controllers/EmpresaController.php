<?php

namespace App\Http\Controllers;

use App\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{

    public function index(){
        $empresas = Empresa::paginate(10);
        return view("Empresas.empresas_dashboard")->withEmpresas($empresas);

    }
    public function nuevaEmpresaForm(){
        return view("Empresas.nueva_empresa");
    }
}

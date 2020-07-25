<?php

namespace App\Http\Controllers;

use App\TipoCategoria;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    public function index(){
        return view("Categorias.categorias");
    }
    public function nuevoTipoCategoria(Request $request){

        $nuevoTipoCategoria= new TipoCategoria();
        $nuevoTipoCategoria->name= $request->input("name");
        $nuevoTipoCategoria->save();

        return redirect()->route("categorias")->withExito("Se creó el nuevo tipo de categoria");
    }
}

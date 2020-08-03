<?php

namespace App\Http\Controllers;

use App\Http\Requests\createMarcasRequest;
use App\Marca;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MarcaController extends Controller
{
    //
    public function index(){
        $marca = Marca::all();

        return View('Marca.marcas')
            ->withNoPagina(1)
            ->withMarca($marca);
    }
    public function storeMarca(createMarcasRequest $request){
        $marca = new Marca();
        $marca->name = $request->input("name");
        $marca->description = $request->input("description");
        $marca->save();
        return redirect()->route("marca");
    }
}

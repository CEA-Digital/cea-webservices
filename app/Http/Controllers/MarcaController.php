<?php

namespace App\Http\Controllers;

use App\Http\Requests\createMarcasRequest;
use App\Marca;
use App\Producto;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MarcaController extends Controller
{
    //Funcion Lista Marca
    public function index(){
        $marca = Marca::paginate(10);

        return View('Marcas.marcas')
            ->withNoPagina(1)
            ->withMarca($marca);
    }
    //Funcion Crear Marca
    public function storeMarca(createMarcasRequest $request){
        $marca = new Marca();
        $marca->name = $request->input("name");
        $marca->description = $request->input("description");
        $marca->save();
        return redirect()->route("marcas");
    }
    //Funcion Editar Marca
    public function editarMarca(createMarcasRequest $request){

    }
    //Funcion Borrar Marca
    public function borrarMarca(Request $request){
        $id = $request->input("id");
        $borrar = Marca::findOrFail($id);
        $updateProducto = Producto::where("id_marca","=",$id)->get();
        foreach ($updateProducto as $producto){
            $producto->id_marca=0;
            $producto->save();
        }
        $borrar->delete();
        return redirect()->route("marcas")->withExito("Marca borrada con éxito");
    }

}

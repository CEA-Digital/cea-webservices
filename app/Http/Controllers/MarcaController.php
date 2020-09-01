<?php

namespace App\Http\Controllers;

use App\Http\Requests\createMarcasRequest;
use App\Marca;
use App\Producto;
use http\QueryString;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class MarcaController extends Controller
{
    //Funcion Lista Marca
    public function index(Request $request){
      if ($request){
          $query = trim($request->get("search"));
          $marca = Marca::where("name","like","%".$query."%")->paginate(10);

          return View('Marcas.marcas')
              ->withNoPagina(1)
              ->withMarca($marca);
      }
    }
    //Funcion Crear Marca
    public function storeMarca(createMarcasRequest $request){
        $marca = new Marca();
        $marca->name = $request->input("name");
        $name = $request->input("name");
        $marca->description = $request->input("description");

        $marca->save();
        return redirect()->route("marcas")->withExito("Marca creada correctamente");
    }
    //Funcion Editar Marca
    public function editarMarca(Request $request){
        $name=Marca::where("name",$request->input("name"))->Where("id","!=",$request->input("id"))->first();

        if ($name!=null){
            try {
                $this->validate($request, [
                    'name'=> 'unique:marcas,name|required|string|max:30',
                    'description'=>'max:100'
                ],$messages = [
                    'name.required'=>'El nombre de la marca es requerido',
                    'name.unique'=>'El nombre de la marca debe de ser unico',
                    'name.max:30'=>'El nombre no puede exceder 30 caracteres',
                    'name.string'=>'El nombre no deben de ser solamente numeros',
                    'description.max:100'=>'La descripcion no debe de excceder de 100 caracteres'
                ]);
                $id = $request->input("id");
                $editar = Marca::findOrFail($id);
                $editar->name=$request->input("name");
                $editar->description=$request->input("description");

                $editar->save();
                return redirect()->route("marcas")->withExito("Marca editada correctamente");
            }catch (ValidationException $exception){
                return redirect()->route("marcas")->with('errores','errores')->with('id_M',$request->input("id"))->withErrors($exception->errors());
            }
        }else{
            try {
                $this->validate($request, [
                    'name'=> 'required|string|max:30',
                    'description'=>'max:100'
                ],$messages = [
                    'name.required'=>'El nombre de la marca es requerido',
                    'name.max:30'=>'El nombre no puede exceder 30 caracteres',
                    'name.string'=>'El nombre no deben de ser solamente numeros',
                    'description.max:100'=>'La descripcion no debe de excceder de 100 caracteres'
                ]);
                $id = $request->input("id");
                $editar = Marca::findOrFail($id);
                $editar->name=$request->input("name");
                $editar->description=$request->input("description");

                $editar->save();
                return redirect()->route("marcas")->withExito("Marca editada correctamente");
            }catch (ValidationException $exception){
                return redirect()->route("marcas")->with('errors','errors')->with('id_M',$request->input("id"))->withErrors($exception->errors());
            }
        }


    }
    //Funcion Borrar Marca
    public function borrarMarca(Request $request){
        $id = $request->input("id");
        $borrar = Marca::findOrFail($id);
        $updateProducto = Producto::where("id_marca","=",$id)->get();
        foreach ($updateProducto as $producto){
            $producto->delete();
        }
        $borrar->delete();
        return redirect()->route("marcas")->withExito("Marca borrada con éxito");
    }

}

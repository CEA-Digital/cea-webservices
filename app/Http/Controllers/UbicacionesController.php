<?php

namespace App\Http\Controllers;

use App\Ubicaciones;
use Illuminate\Http\Request;

class UbicacionesController extends Controller
{
    public function store(Request $request){

        $nuevaUbicacion= new Ubicaciones();
        if($request->input("id_empresa")) {
            $nuevaUbicacion->descripcion = $request->input("descripcion");
            $nuevaUbicacion->id_empresa = $request->input("id_empresa");
            $nuevaUbicacion->longitud = $request->input("longitud");
            $nuevaUbicacion->latitud = $request->input("latitud");
            $nuevaUbicacion->save();
            return redirect()->route("nuevaUbicacionEmpresa",["id"=>$request->input("id_empresa")]);
        }else{
            return redirect()->route("nuevaUbicacionEmpresa",["id"=>$request->input("id_empresa")])
                ->withError("El ID de empresa es erronéo o no se encuentra ninguna ubicacion con el.");
        }

    }

    public function destroy(Request $request){
        $ubicacion = Ubicaciones::findOrFail($request->input("id"));
        $ubicacion->delete();

        return redirect()->route("nuevaUbicacionEmpresa",["id"=>$request->input("id_empresa")])
            ->withExito("Se eliminó correctamente la ubicación.");

    }
}

<?php

namespace App\Http\Controllers;

use App\Categorias;
use App\ResourcesMedia;
use App\TipoCategoria;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    public function index(){
        $tipoCategoria= TipoCategoria::all();
        $categorias = Categorias::all();
        return view("Categorias.categorias")
            ->withNoPagina(1)
            ->withCategorias($categorias)
            ->withTipoCategorias($tipoCategoria);
    }
    public function verTipoCategorias(){
        $tipoCategorias = TipoCategoria::all();
        return view("categorias.tipo_categorias")->with("tiposCategorias",$tipoCategorias);

    }
    public function nuevoTipoCategoria(Request $request){

        $this->validate($request,[
            "name"=>"string|max:100|required"
        ]);
        $nuevoTipoCategoria= new TipoCategoria();
        $nuevoTipoCategoria->name= $request->input("name");
        $nuevoTipoCategoria->save();

        if($request->input("fuenteRuta")=="/categoria") {
            return redirect()->route("categorias")
                ->with("idNuevaCategoria", $nuevoTipoCategoria->id)
                ->withExito("Se creó el nuevo tipo de categoria con nombre '"
                    . $request->input("name") . "' con ID= " . $nuevoTipoCategoria->id . "");
        }else{
            return redirect()->route("verTipoCategorias")
                ->with("idNuevaCategoria", $nuevoTipoCategoria->id)
                ->withExito("Se creó el nuevo tipo de categoria con nombre '"
                    . $request->input("name") . "' con ID= " . $nuevoTipoCategoria->id . "");
        }
    }

    public function storeCategoria(Request $request){
        $path = public_path().'/images/categorias';//Carpeta publica de las imagenes

        $nuevaCategoria = new Categorias();
        if($request->input("imagen_url")!=null){
            $imagen = $_FILES["imagen_url"]["name"];
            $ruta = $_FILES["imagen_url"]["tmp_name"];
            //-------------VALIDAR SI LA CARPETA EXISTE---------------------
            if(!file_exists($path)){
                mkdir($path,0755,true,true);
            }
            //-------------------------------------------------------------
            $destino = "images/categorias/" . $imagen;
            copy($ruta, $destino);
            $nuevaCategoria->img_url=$imagen;
        }
        $nuevaCategoria->name= $request->input("name");
        $nuevaCategoria->id_categoria=$request->input("id_categoria");
        $nuevaCategoria->descripcion=$request->input("descripcion");
        $nuevaCategoria->save();

        return redirect()->route("categorias")
            ->withExito("Se creó nueva categoria con nombre '"
                .$request->input("name")."' con ID= ".$nuevaCategoria->id."");
    }
}

<?php

namespace App\Http\Controllers;

use App\Categorias;
use App\Empresa;
use App\ResourcesMedia;
use App\TipoCategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoriasController extends Controller
{
    public function index()
    {
        $tipoCategoria = TipoCategoria::all();
        $categorias = Categorias::paginate(10);
        return view("Categorias.categorias")
            ->withNoPagina(1)
            ->withCategorias($categorias)
            ->withTipoCategorias($tipoCategoria);
    }

    public function buscarCategorias(Request $request){
        $busqueda = $request->input("busqueda");
        $tipoCategoria = TipoCategoria::all();
        $categorias = Categorias::where("name","like","%".$busqueda."%")
            ->orWhere("descripcion","like","%".$busqueda."%")
            ->paginate(10);
        return view("Categorias.categorias")
            ->withNoPagina(1)
            ->withBusqueda($busqueda)
            ->withCategorias($categorias)
            ->withTipoCategorias($tipoCategoria);
    }

    public function storeCategoria(Request $request)
    {
        $path = public_path() . '/images/categorias';//Carpeta publica de las imagenes

        $nuevaCategoria = new Categorias();
        if ($request->imagen_url) {
            $imagen = $_FILES["imagen_url"]["name"];
            $ruta = $_FILES["imagen_url"]["tmp_name"];
            //-------------VALIDAR SI LA CARPETA EXISTE---------------------
            if (!file_exists($path)) {
                mkdir($path, 0777, true, true);
            }
            //-------------------------------------------------------------
            $destino = "images/categorias/" . $imagen;
            copy($ruta, $destino);
            $nuevaCategoria->img_url = $imagen;
        }
        $nuevaCategoria->name = $request->input("name");
        $nuevaCategoria->id_categoria = $request->input("id_categoria");
        $nuevaCategoria->descripcion = $request->input("descripcion");
        $nuevaCategoria->save();

        return redirect()->route("categorias")
            ->withExito("Se creó nueva categoria con nombre '"
                . $request->input("name") . "' con ID= " . $nuevaCategoria->id . "");
    }



    public function borrarCategoria(Request $request){
        //TODO verificar si hay recursos usados por este registro

        $categoria= Categorias::findOrFail($request->id);
        $image_ruta= public_path()."/images/categorias/".$categoria->img_url;
        if(File::exists($image_ruta)){
         File::delete($image_ruta);
        }
        $categoria->delete();

        return redirect()->route("categorias")
            ->withExito("Se eliminó exitosamente la categoria y sus imagenes");


    }

    public function editarCategoria(Request $request){
        $this->validate($request,[
            "name"=>"required|max:100"
        ]);

        $path = public_path() . '/images/categorias';//Carpeta publica de las imagenes


        $categoria = Categorias::findOrFail($request->id);

        $categoria->name= $request->input("name");
        if ($request->imagen_url) {
            /***Si la imagen es enviada por el usuario se debe eliminar la anterior **/
            $img_anterior=public_path()."/images/categorias/".$categoria->img_url;
            if (File::exists($img_anterior)){
                File::delete($img_anterior);
            }
            /**-------------------------------------------*/
            $imagenEditada = $_FILES["imagen_url"]["name"];
            $ruta = $_FILES["imagen_url"]["tmp_name"];
            //-------------VALIDAR SI LA CARPETA EXISTE---------------------
            if (!file_exists($path)) {
                mkdir($path, 0777, true, true);
            }
            //-------------------------------------------------------------
            $destino = "images/categorias/" . $imagenEditada;
            copy($ruta, $destino);
            $categoria->img_url = $imagenEditada;
        }
        $categoria->descripcion=$request->input("descripcion");
        $categoria->id_categoria=$request->input("id_categoria");

        $categoria->save();
        return redirect()->route("categorias")->withExito("Categoria editada exitosamente");

    }



    /**-------------------------METODOS PARA TIPO DE CATEGORIAS----------------------------------------**/

    public function verTipoCategorias()
    {
        $tipoCategorias = TipoCategoria::paginate(10);
        return view("categorias.tipo_categorias")
            ->withNoPagina(1)
            ->with("tiposCategorias", $tipoCategorias);
    }

    public function nuevoTipoCategoria(Request $request)
    {

        $this->validate($request, [
            "name" => "string|max:100|required"
        ]);
        $nuevoTipoCategoria = new TipoCategoria();
        $nuevoTipoCategoria->name = $request->input("name");
        $nuevoTipoCategoria->save();

        return redirect()->route($request->input("fuenteRuta"))
            ->with("idNuevaCategoria", $nuevoTipoCategoria->id)
            ->withExito("Se creó el nuevo tipo de categoria con nombre '"
                . $request->input("name") . "' con ID= " . $nuevoTipoCategoria->id . "");


    }


    public function borrarTipoCategoria(Request $request)
    {
        $idCategoria = $request->input("idCategoria");

        //TODO Validar si se encuentra en una tabla relacionado antes de borrarlo

        $exiteEnEmpresa = Empresa::where("id_categoria", $idCategoria)->get();
        if ($exiteEnEmpresa) {

        }

        $borrarCategoria = TipoCategoria::findOrFail($idCategoria);
        $borrarCategoria->delete();


        return redirect()->route("verTipoCategorias")
            ->withExito("Se eliminó con exito el tipo de categoria");
    }

    public function buscarTipoCategorias(Request $request)
    {
        $busqueda = $request->input("busqueda");
        $tipoCategorias = TipoCategoria::where("name", "like", "%" . $busqueda . "%")->paginate(5);

        return view("categorias.tipo_categorias")
            ->withNoPagina(1)
            ->withBusqueda($busqueda)
            ->with("tiposCategorias", $tipoCategorias);
    }

    public function editarTipoCategoria(Request $request)
    {
        $this->validate($request, [
            "name" => "required|max:100",
        ]);
        $tipoCategoria = TipoCategoria::findOrFail($request->input("id"));
        $tipoCategoria->name = $request->input("name");
        $tipoCategoria->save();

        return redirect()->route("verTipoCategorias")
            ->withExito("Se editó con exito el tipo de categoria");
    }

}

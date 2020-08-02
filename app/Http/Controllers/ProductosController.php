<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Http\Requests\CreateProductosRequest;
use App\Producto;
use App\ResourcesMedia;
use App\TipoCategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductosController extends Controller
{
    //
    public function index(){
        $productos=DB::table("productos")
        ->leftJoin("categorias","productos.id_categoria","=","categorias.id")
            ->leftJoin("tipo_categorias", "categorias.id_categoria", "=", "tipo_categorias.id")
            ->leftJoin("empresas","productos.id_empresa","=","empresas.id")
        ->leftJoin("resources_media","productos.id","=","resources_media.id_prod")
        ->select("productos.id","productos.name","productos.description","productos.unit_price","productos.lote_price",
            "productos.disponible","empresas.name AS nombre_empresa","productos.profile_img_url as imagen_url","categorias.name as nombre_categoria",
            "productos.id_categoria","productos.id_empresa")->paginate(10);
        $empresas = Empresa::all();
        $tipo_Categoria = TipoCategoria::all();

        return view("Productos.productos")
            ->withNoPagina(1)
            ->withProductos($productos)
            ->withEmpresas($empresas)
            ->withTipoCategoria($tipo_Categoria);
    }

    public function storeProductos(CreateProductosRequest $request){
        $nuevoProducto = new Producto();

            $nuevoProducto->name=$request->input('name');
            $nuevoProducto->description=$request->input('description');
            $nuevoProducto->unit_price=$request->input('unit_price');
            $nuevoProducto->lote_price=$request->input('lote_price');
            $nuevoProducto->id_categoria=$request->input('id_categoria');
            $nuevoProducto->id_empresa=$request->input('id_empresa');
            $nuevoProducto->disponible=$request->input('disponible');


        $path = public_path() . '\images\productos';//Carpeta publica de las imagenes

        if ($request->imagen_url) {
            $imagen = $_FILES["imagen_url"]["name"];
            $ruta = $_FILES["imagen_url"]["tmp_name"];
            //-------------VALIDAR SI LA CARPETA EXISTE---------------------
            if (!file_exists($path)) {
                mkdir($path, 0777, true, true);
            }
            //-------------------------------------------------------------
            $destino = "images/productos/" . $imagen;
            copy($ruta, $destino);
            $nuevoProducto->profile_img_url=$imagen;
        }
        $nuevoProducto->save();

        return redirect()->route("productos")->withExito("Se creó un producto con nombre '"
            . $request->input("name"));

    }
    public function editarProductos(Request $request){
        $editarProductos=Producto::findOrFail($request->id);
        $editarProductos->name=$request->input('name');
        $editarProductos->description=$request->input('description');
        $editarProductos->unit_price=$request->input('unit_price');
        $editarProductos->lote_price=$request->input('lote_price');
        $editarProductos->id_categoria=$request->input('id_categoria');
        $editarProductos->id_empresa=$request->input('id_empresa');
        $editarProductos->disponible=$request->input('disponible');

        $path = public_path() . '\images\productos';//Carpeta publica de las imagenes
        if ($request->imagen_url) {
            /***Si la imagen es enviada por el usuario se debe eliminar la anterior **/
            $img_anterior=public_path()."/images/productos/".$editarProductos->img_url;
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
            $destino = "images/productos/" . $imagenEditada;
            copy($ruta, $destino);
            $editarProductos->profile_img_url = $imagenEditada;
        }

        $editarProductos->save();
        return redirect()->route("productos")->withExito("Se editó un producto con nombre "
            . $request->input("name"));

    }
    public function borrarProducto(Request $request){

        $producto = $request->input('id');
        $borrar = Producto::findOrFail($producto);
        $image_ruta= public_path()."/images/productos/".$borrar->profile_img_url;
        if(File::exists($image_ruta)){
            File::delete($image_ruta);
        }
        $catalogo_producto=ResourcesMedia::where("id_prod","=",$producto)->get();
        foreach ($catalogo_producto as $catalogo){
            if(File::exists($catalogo->ruta)){
                File::delete($catalogo->ruta);
            }
        }
        $borrar->delete();
        return redirect()->route("productos")->withExito("Se borró el producto satisfactoriamente");
    }
}

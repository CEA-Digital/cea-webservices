<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Producto;
use App\ResourcesMedia;
use App\TipoCategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductosController extends Controller
{
    //
    public function index(){
        $productos=DB::table("productos")
        ->leftJoin("categorias","productos.id_categoria","=","categorias.id")
            ->leftJoin("tipo_categorias", "categorias.id_categoria", "=", "tipo_categorias.id")
            ->leftJoin("empresas","productos.id_empresa","=","empresas.id")
        ->leftJoin("resources_media","productos.id_product_img","=","resources_media.id")
        ->select("productos.id","productos.name","productos.description","productos.unit_price","productos.lote_price",
            "productos.disponible","empresas.name AS nombre_empresa","resources_media.ruta As imagen_url","categorias.name as nombre_categoria")->paginate(10);
        $empresas = Empresa::all();
        $tipo_Categoria = TipoCategoria::all();

        return view("Productos.productos")
            ->withNoPagina(1)
            ->withProductos($productos)
            ->withEmpresas($empresas)
            ->withTipoCategoria($tipo_Categoria);
    }

    public function storeProductos(Request $request){
        $path = public_path() . '\images\productos';//Carpeta publica de las imagenes

         $nuevoProducto = new Producto();
        if ($request->imagen_url) {
            $imagen = $_FILES["imagen_url"]["name"];
            $ruta = $_FILES["imagen_url"]["tmp_name"];
            //-------------VALIDAR SI LA CARPETA EXISTE---------------------
            if (!file_exists($path)) {
                mkdir($path, 0777);
            }
            //-------------------------------------------------------------
            $destino = "images/productos/" . $imagen;
            copy($ruta, $destino);
            $resources = ResourcesMedia::create([
                'ruta' => $imagen
            ]);
             $id = $resources->id;

            $nuevoProducto->name=$request->input('name');
            $nuevoProducto->description=$request->input('descripcion');
            $nuevoProducto->id_product_img=$id;
            $nuevoProducto->unit_price=1;
            $nuevoProducto->lote_price=1;
            $nuevoProducto->id_categoria=$request->input('id_categoria');
            $nuevoProducto->id_empresa=3;
            $nuevoProducto->save();

            return redirect()->route("productos")->withExito("Se creó un producto con nombre '"
                . $request->input("name"));

        }

    }

}

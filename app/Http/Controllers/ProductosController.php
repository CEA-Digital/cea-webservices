<?php

namespace App\Http\Controllers;

use App\Categorias;
use App\Empresa;
use App\Http\Requests\CreateProductosRequest;
use App\Marca;
use App\Producto;
use App\ResourcesMedia;
use App\TipoCategoria;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use function GuzzleHttp\Promise\exception_for;

class ProductosController extends Controller
{
    //
    public function index(Request $request){
        if ($request){
            $query = trim($request->get("search"));
            $productos=DB::table("productos")
                ->leftJoin("categorias","productos.id_categoria","=","categorias.id")
                ->leftJoin("empresas","productos.id_empresa","=","empresas.id")
                ->leftJoin("resources_media","productos.id","=","resources_media.id_prod")
                ->leftJoin("marcas","productos.id_marca","=","marcas.id")
                ->select("productos.id","productos.name","productos.description","productos.unit_price","productos.lote_price",
                    "productos.disponible","empresas.name AS nombre_empresa","productos.profile_img_url as imagen_url","categorias.name as nombre_categoria",
                    "productos.id_categoria","productos.id_empresa","productos.id_marca","marcas.name as nombre_marca")
                ->where("productos.name","Like","%".$query."%")
                ->paginate(10);
            $empresas = Empresa::all();
            $categoria = Categorias::all();
            $tipoCategoria = TipoCategoria::all();
            $marca = Marca::all();

            return view("Productos.productos")
                ->withNoPagina(1)
                ->withProductos($productos)
                ->withEmpresas($empresas)
                ->withCategoria($categoria)
                ->withTipoCategorias($tipoCategoria)
                ->withMarca($marca);
        }

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
            $nuevoProducto->id_marca=$request->input("id_marca");


        $path = public_path() . '\images\productos';//Carpeta publica de las imagenes

        if ($request->imagen_url) {
            $imagen = $_FILES["imagen_url"]["name"];
            $ruta = $_FILES["imagen_url"]["tmp_name"];
            //-------------VALIDAR SI LA CARPETA EXISTE---------------------
            if (!file_exists($path)) {
                mkdir($path, 0777, true);

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

          try{
              $this->validate($request, [
                  'name'=>'required|string|max:100',
                  'description'=>'max:192',
                  'unit_price'=>'required|numeric|max:9999',
                  'lote_price'=>'required|numeric|max:99999',
                  'profile_img_url'=>'nullable',
                  'disponible'=>'required|boolean',
                  'id_empresa'=>'required|integer',
                  'id_categoria'=>'required|integer',
                  'id_marca'=>'required|integer'
              ],$messages = [
                  'name.required' => 'El nombre del producto es requerido.',
                  'description.max:192' => 'La descripción  no debe de tener más de 192 caracteres.',
                  'unit_price.numeric' => 'El precio debe ser un valor numérico.',
                  'unit_price.max:9999' =>'El precio unitario no debe de exceder de 9 caracteres',
                  'lote_price.max:99999' =>'El precio de lote no debe de exceder de 9 caracteres',
                  'lote_price.numeric' =>'El precio lote debe ser un valor numericos',
                  'id_empresa.required' => 'Se requiere una empresa para este producto.',
                  'id_categoria.required' => 'Se requiere una categoria para este producto.',
                  'id_marca.required'=>'Se requiere una marca para este producto'

              ]);
              $editarProductos=Producto::findOrFail($request->id);
              $editarProductos->name=$request->input('name');
              $editarProductos->description=$request->input('description');
              $editarProductos->unit_price=$request->input('unit_price');
              $editarProductos->lote_price=$request->input('lote_price');
              $editarProductos->id_categoria=$request->input('id_categoria');
              $editarProductos->id_empresa=$request->input('id_empresa');
              $editarProductos->disponible=$request->input('disponible');
              $editarProductos->id_marca=$request->input("id_marca");


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
                      mkdir($path, 0777, true);
                  }
                  //-------------------------------------------------------------
                  $destino = "images/productos/" . $imagenEditada;
                  copy($ruta, $destino);
                  $editarProductos->profile_img_url = $imagenEditada;
              }

              $editarProductos->save();
              return redirect()->route("productos")->withExito("Se editó un producto con nombre "
                  . $request->input("name"));

          }catch (ValidationException $exception){
              return redirect()->route("productos")->with('errores','errores')->with('id_producto',$request->input("id"))->withErrors($exception->errors());
          }

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

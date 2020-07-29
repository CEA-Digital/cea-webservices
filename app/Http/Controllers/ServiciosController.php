<?php

namespace App\Http\Controllers;

use App\Categorias;
use App\Empresa;

use App\Http\Requests\CreateServiciosRequest;
use App\ResourcesMedia;
use App\Servicio;
use App\TipoCategoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {


        if ($request) {
            $query = trim($request->get('search'));

            $servicios = DB::table("servicios")
                ->leftJoin("empresas", "servicios.id_empresa", "=", "empresas.id")
                ->leftJoin("categorias", "servicios.id_categoria", "=", "categorias.id")
                ->leftJoin("tipo_categorias", "categorias.id_categoria", "=", "tipo_categorias.id")
                ->select("servicios.id_empresa","servicios.id_categoria","servicios.id","servicios.name", "servicios.descripcion", "servicios.condiciones", "servicios.precio",
                    "servicios.servicio_img_id", "Empresas.name As name_empresa", "categorias.name As name_categoria")
                ->where('servicios.name','LIKE','%'.$query.'%')->get();


            $categorias = Categorias::Orderby('name', 'ASC')->get();
            $empresas = Empresa::Orderby('name', 'ASC')->get();
            $tipoCategorias = TipoCategoria::Orderby('name', 'ASC')->get();
            return view('Servicios.servicios_index')->with("tipoCategorias", $tipoCategorias)->with("categorias", $categorias)->with("empresas", $empresas)->with("servicios", $servicios)->withNoPagina(1);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateServiciosRequest $request)
    {
           $servicio = new Servicio();


        $foto ='';
        if($foto = Servicio::setCaratula($request->servicio_img_id)){
            $request->request->add(['imagen_servicio'=>$foto]);
            $servicio->servicio_img_id = $request->imagen_servicio;

        }

        $servicio->name = ucwords(strtolower($request->name));
        $servicio->descripcion = $request->descripcion;
        $servicio->condiciones = $request->condiciones;
        $servicio->precio = $request->precio;
         $servicio->id_categoria = $request->id_categoria;
        $servicio->id_empresa = $request->id_empresa;




        $servicio->save();


        return redirect()->route("servicios.index")
            ->withExito("Se creó un nuevo servicio con nombre '"
                .$request->input("name")."' con ID= ".$servicio->id."");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    public function editarServicio(Request $request)
    {
              $servicio =  Servicio::findOrFail($request->id);


            if($foto = Servicio::setCaratula($request->servicio_img_id, $servicio->servicio_img_id)){
                $request->request->add(['imagen_servicio'=>$foto]);
                $servicio->servicio_img_id = $request->imagen_servicio;


            }


            $servicio->name = $request->get('name');
            $servicio->condiciones = $request->get('condiciones');
            $servicio->precio = $request->get('precio');
            $servicio->id_empresa = $request->get('id_empresa');
            $servicio->id_categoria = $request->get('id_categoria');
            $servicio->descripcion= $request->get('descripcion');




        $servicio->update();

        return redirect()->route("servicios.index")
            ->withExito("Se actualizó un nuevo servicio con nombre '");





    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyServicio(Request $request)
    {

        $servicio = Servicio::findOrFail($request->id);
        $resorces = ResourcesMedia::where("id_serv",'=',$request->id)->get();

         Servicio::deleteCaratula($servicio->servicio_img_id);

        foreach ($resorces as $resorce)
        {
            Servicio::deleteCaratula($resorce->ruta);

        }

        $servicio->delete();
        ResourcesMedia::where("id_serv",'=',$request->id)->delete();


        return redirect()->route("servicios.index")
            ->withExito("Se eliminó el servicio  '");

    }
    public function nuevaCategoria(Request $request)
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

        return redirect()->route("servicios.index")->with("idNuevaCategoria", $nuevaCategoria->id)
            ->withExito("Se creó nueva categoria con nombre '"
                . $request->input("name") . "' con ID= " . $nuevaCategoria->id . "");
    }
}

<?php

namespace App\Http\Controllers;

use App\Categorias;
use App\Empresa;

use App\Http\Requests\CreateServiciosRequest;
use App\Servicio;
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
                ->select("servicios.id","servicios.name", "servicios.descripcion", "servicios.condiciones", "servicios.precio",
                    "servicios.servicio_img_id", "servicios.servicio_img_id", "Empresas.name As name_empresa", "tipo_categorias.name As name_categoria")
                ->where('servicios.name','LIKE','%'.$query.'%')->get();


            $categorias = Categorias::Orderby('name', 'ASC')->get();
            $empresas = Empresa::Orderby('name', 'ASC')->get();
            return view('Servicios.servicios_index')->with("categorias", $categorias)->with("empresas", $empresas)->with("servicios", $servicios)->withNoPagina(1);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
